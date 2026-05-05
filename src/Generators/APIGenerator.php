<?php
namespace EnzanRocket\Generator\Generators;

use EnzanRocket\Generator\Generators\API\ResponseGenerator;
use EnzanRocket\Generator\Generators\API\RouteGenerator;
use EnzanRocket\Generator\Services\SwaggerService;

class APIGenerator extends Generator
{
    protected $document;

    protected $generators = [
        RouteGenerator::class,
        ResponseGenerator::class,
    ];

    public function generate($name, $overwrite = false, $baseDirectory = null, $additionalData = [])
    {
        $ret = $this->readSwaggerFile($name);
        if (!$ret) {
            return;
        }

        foreach ($this->generators as $generator) {
            $generator = app()->make($generator);
            $generator->generate($name, $overwrite, $baseDirectory, [
                'document' => $this->document,
            ]);
        }
    }

    /**
     * @param string $swaggerPath
     *
     * @return bool
     */
    protected function readSwaggerFile($swaggerPath)
    {
        $swaggerService = new SwaggerService();
        $this->document = $swaggerService->parse($swaggerPath);

        if (empty($this->document)) {
            print 'Swagger File Parse Error'.PHP_EOL;

            return false;
        }

        return true;
    }
}
