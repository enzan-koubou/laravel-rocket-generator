<?php
namespace EnzanRocket\Generator\Tests\Objects;

use EnzanRocket\Generator\Services\SwaggerService;
use EnzanRocket\Generator\Tests\TestCase;

class SwaggerTest extends TestCase
{
    public function testGetFromYaml()
    {
        $dataPath = realpath(__DIR__.'/../data/sample_swagger.yaml');
        $service  = new SwaggerService();
        $document = $service->parse($dataPath);

        $this->assertNotEmpty($document);
        $this->assertEquals('/api/v1', $document->basePath);
    }

    public function testGetFromJson()
    {
        $dataPath = realpath(__DIR__.'/../data/sample_swagger.json');
        $service  = new SwaggerService();
        $document = $service->parse($dataPath);

        $this->assertNotEmpty($document);
        $this->assertEquals('/api/v1', $document->basePath);
    }
}
