<?php
namespace EnzanRocket\Generator\Console\Commands;

use EnzanRocket\Generator\Generators\HelperGenerator;

class HelperGeneratorCommand extends GeneratorCommand
{
    protected $name        = 'rocket:make:helper';

    protected $description = 'Create a new helper class';

    protected $generator   = HelperGenerator::class;
}
