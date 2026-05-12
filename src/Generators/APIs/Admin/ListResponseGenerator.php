<?php

namespace EnzanRocket\Generator\Generators\APIs\Admin;


class ListResponseGenerator extends BaseAdminAPIGenerator
{
    /**
     * @return string
     */
    protected function getPath(): string
    {
        $modelName = $this->getModelName();

        return app_path('Http/Responses/Api/Admin/'.\ICanBoogie\StaticInflector::pluralize($modelName).'.php');
    }

    /**
     * @return string
     */
    protected function getView(): string
    {
        return 'api.admin.list_response';
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        return \ICanBoogie\StaticInflector::pluralize($this->getModelName());
    }
}
