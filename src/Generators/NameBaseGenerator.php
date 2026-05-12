<?php

namespace EnzanRocket\Generator\Generators;

use Illuminate\Support\Str;


class NameBaseGenerator extends BaseGenerator
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \EnzanRocket\Generator\Objects\Definitions
     */
    protected $json;

    /**
     * @param string                                       $name
     * @param \EnzanRocket\Generator\Objects\Definitions $json
     *
     * @return bool
     */
    public function generate(string $name, $json): bool
    {
        $this->json = $json;
        $this->name = $this->normalizeName($name);

        if (!$this->canGenerate()) {
            return false;
        }

        $view      = $this->getView();
        $variables = $this->getVariables();

        $path = $this->getPath();
        if (file_exists($path)) {
            unlink($path);
        }
        $this->fileService->render($view, $path, $variables);

        return true;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function normalizeName(string $name): string
    {
        return ucfirst(Str::camel(\ICanBoogie\StaticInflector::singularize($name)));
    }

    /**
     * @return array
     */
    protected function getVariables(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getRepositories(): array
    {
        $repositories = [];

        $path  = app_path('Repositories');
        $files = scandir($path);
        foreach ($files as $file) {
            if (preg_match('/^(.+)RepositoryInterface.php$/', $file, $matches)) {
                $repositories[] = $matches[1].'Repository';
            }
        }

        return $repositories;
    }
}
