<?php

namespace EnzanRocket\Generator\Objects\OpenAPI;

class Path
{
    /** @var string */
    protected $path;

    /** @var string */
    protected $method;

    protected $data;

    /** @var \EnzanRocket\Generator\Objects\OpenAPI\PathElement[] */
    protected $elements;

    /** @var \EnzanRocket\Generator\Objects\OpenAPI\Action */
    protected $action;

    /** @var \EnzanRocket\Generator\Objects\OpenAPI\OpenAPISpec */
    protected $spec;

    /**
     * Path constructor.
     *
     * @param string $path
     * @param string $method
     * @param $data
     * @param \EnzanRocket\Generator\Objects\OpenAPI\OpenAPISpec $spec
     */
    public function __construct($path, $method, $data, $spec)
    {
        $this->path   = $path;
        $this->method = $method;
        $this->data   = $data;
        $this->spec   = $spec;

        $this->parseElements();
        $this->parseActions();
    }

    /**
     * @return \EnzanRocket\Generator\Objects\OpenAPI\Action
     */
    public function getAction()
    {
        return $this->action;
    }

    protected function parseElements()
    {
        $this->elements = PathElement::parsePath($this->path, $this->method);
    }

    protected function parseActions()
    {
        $this->action = new Action($this->path, $this->method, $this->data, $this->spec);
    }
}
