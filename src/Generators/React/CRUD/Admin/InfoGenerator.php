<?php

namespace EnzanRocket\Generator\Generators\React\CRUD\Admin;

use EnzanRocket\Generator\Generators\React\CRUD\ReactCRUDBaseGenerator;


class InfoGenerator extends ReactCRUDBaseGenerator
{
    /**
     * @return string
     */
    protected function getPath(): string
    {
        $modelName = $this->getModelName();

        return resource_path('assets/admin/src/views/'.\ICanBoogie\StaticInflector::pluralize($modelName).'/_info.js');
    }

    /**
     * @return string
     */
    protected function getView(): string
    {
        return 'react.crud.admin._info';
    }
}
