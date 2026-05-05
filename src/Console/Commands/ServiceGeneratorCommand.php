<?php
namespace EnzanRocket\Generator\Console\Commands;

use EnzanRocket\Generator\Generators\ServiceGenerator;

class ServiceGeneratorCommand extends GeneratorCommand
{
    protected $name        = 'rocket:make:service';

    protected $description = 'Create a new service class';

    protected $generator   = ServiceGenerator::class;
}
