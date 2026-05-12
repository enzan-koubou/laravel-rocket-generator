<?php
namespace EnzanRocket\Generator\Generators;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AlterMigrationGenerator extends Generator
{
    public function generate($name, $overwrite = false, $baseDirectory = null, $additionalData = [])
    {
        $action = Arr::get($additionalData, 'action', 'undefined');
        $this->generateMigration($name, $action);
    }

    protected function generateMigration($name, $action)
    {
        $name = $this->getTableName($name);

        if (class_exists($className = $this->getAlterClassName($name, $action))) {
            throw new InvalidArgumentException("A $className migration already exists.");
        }

        $path         = $this->getPath($name, $action);
        $stubFilePath = $this->getStubPath('/migration/alter.stub');

        return $this->generateFile($className, $path, $stubFilePath, [
            'CLASS' => $className,
            'TABLE' => $name,
        ]);
    }

    protected function getTableName($name)
    {
        return \ICanBoogie\StaticInflector::pluralize(Str::snake($name));
    }

    protected function getAlterClassName($name, $action)
    {
        return 'Alter'.ucfirst(Str::camel($name)).ucfirst(Str::camel($action)).'Table';
    }

    protected function getPath($name, $action)
    {
        $basePath = database_path('migrations');
        $action   = Str::snake($action);

        return $basePath.'/'.date('Y_m_d_His').'_alter_'.$name.'_'.$action.'_table.php';
    }
}
