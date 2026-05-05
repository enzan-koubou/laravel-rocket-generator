<?php
namespace EnzanRocket\Generator\Console\Commands;

use EnzanRocket\Generator\Generators\AlterMigrationGenerator;
use Symfony\Component\Console\Input\InputArgument;

class AddDIComponent extends GeneratorCommand
{
    protected $signature   = 'rocket:add-di-component {class} {component}';

    protected $description = 'Add a DI component binding to the service provider';

    protected $generator   = AlterMigrationGenerator::class;

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the table'],
            ['actions', InputArgument::REQUIRED, 'Alter actions'],
        ];
    }
}
