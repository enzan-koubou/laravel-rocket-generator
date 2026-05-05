<?php
namespace EnzanRocket\Generator\Console\Commands;

use EnzanRocket\Generator\Generators\ModelGenerator;

class ModelGeneratorCommand extends GeneratorCommand
{
    protected $name        = 'rocket:make:model';

    protected $description = 'Create a new model class';

    protected $generator   = ModelGenerator::class;
}
