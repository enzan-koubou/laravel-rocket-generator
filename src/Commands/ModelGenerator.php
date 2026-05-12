<?php

namespace EnzanRocket\Generator\Commands;

use Illuminate\Support\Str;
use EnzanRocket\Generator\Generators\Models\ColumnLanguageFileGenerator;
use EnzanRocket\Generator\Generators\Models\ConfigFileGenerator;
use EnzanRocket\Generator\Generators\Models\ModelFactoryGenerator;
use EnzanRocket\Generator\Generators\Models\ModelUnitTestGenerator;
use EnzanRocket\Generator\Generators\Models\PresenterGenerator;
use EnzanRocket\Generator\Generators\Models\RelationLanguageFileGenerator;
use EnzanRocket\Generator\Services\DatabaseService;


class ModelGenerator extends MWBGenerator
{
    protected $name = 'rocket:make:model';

    protected $signature = 'rocket:make:model {name} {--file=} {--json=}';

    protected $description = 'Create Model';

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $this->tables = $this->getTablesFromMWBFile();
        if ($this->tables === false) {
            return false;
        }
        $this->getAppJson();

        $this->databaseService = new DatabaseService($this->config, $this->files);
        $this->databaseService->resetDatabase();

        $this->generate();

        $this->databaseService->dropDatabase();

        return true;
    }

    protected function normalizeName(string $name): string
    {
        return Str::snake(\ICanBoogie\StaticInflector::pluralize($name));
    }

    protected function generate()
    {
        /** @var \EnzanRocket\Generator\Generators\TableBaseGenerator[] $generators */
        $generators = [
            new \EnzanRocket\Generator\Generators\Models\ModelGenerator($this->config, $this->files, $this->view, $this->json),
            new ModelFactoryGenerator($this->config, $this->files, $this->view, $this->json),
            new ModelUnitTestGenerator($this->config, $this->files, $this->view, $this->json),
            new PresenterGenerator($this->config, $this->files, $this->view, $this->json),
            new ColumnLanguageFileGenerator($this->config, $this->files, $this->view, $this->json),
            new RelationLanguageFileGenerator($this->config, $this->files, $this->view, $this->json),
            new ConfigFileGenerator($this->config, $this->files, $this->view, $this->json),
        ];

        /** @var \EnzanRocket\Generator\FileUpdaters\TableBaseFileUpdater[] $fileUpdaters */
        $fileUpdaters = [
        ];

        $name = $this->normalizeName($this->argument('name'));

        $table = $this->findTableFromName($name);
        if (empty($table)) {
            $this->output('No table definition found: '.$name, 'red');

            return;
        }

        $this->output('Processing '.ucfirst(\ICanBoogie\StaticInflector::singularize($name)).' ...', 'green');
        foreach ($generators as $generator) {
            $generator->generate($table, $this->tables, $this->json);
        }
        foreach ($fileUpdaters as $fileUpdater) {
            $fileUpdater->insert($table, $this->tables, $this->json);
        }
    }
}
