<?php
namespace EnzanRocket\Generator\Console\Commands;

use EnzanRocket\Generator\Generators\APIGenerator;

class APIGeneratorCommand extends GeneratorCommand
{
    protected $name        = 'rocket:make:api';

    protected $description = 'Create APIs from Swagger file';

    protected $generator   = APIGenerator::class;

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $name = $this->getTargetName();

        return $this->generate($name, $this->getAdditionalData());
    }
}
