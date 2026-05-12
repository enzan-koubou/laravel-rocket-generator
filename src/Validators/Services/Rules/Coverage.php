<?php

namespace EnzanRocket\Generator\Validators\Services\Rules;

use Illuminate\Support\Arr;
use EnzanRocket\Generator\Validators\BaseRule;
use EnzanRocket\Generator\Validators\Error;

class Coverage extends BaseRule
{
    public function validate($data)
    {
        $name = Arr::get($data, 'name');

        /** @var \EnzanRocket\Generator\Objects\ClassLike $interface */
        $interface = Arr::get($data, 'interface');
        /** @var \EnzanRocket\Generator\Objects\ClassLike $class */
        $class = Arr::get($data, 'class');
        /** @var \EnzanRocket\Generator\Objects\ClassLike $test */
        $test = Arr::get($data, 'test');

        $errors = [];

        if (!file_exists($test->getPath())) {
            $errors[] = new Error(
                'TestFile  '.$test->getPath().' does\'t exists.',
                Error::LEVEL_ERROR,
                $name,
                'Add unit test file named : '.$test->getPath()
            );

            return $this->response($errors);
        }

        $testMethods = $test->getMethods();
        foreach ($interface->getMethods() as $methodName => $method) {
            $testName = 'test'.ucfirst($methodName);
            if (!array_key_exists($testName, $testMethods)) {
                $errors[] = new Error(
                    'Method '.$methodName.' has no test method ( '.$testName.').',
                    Error::LEVEL_ERROR,
                    $name,
                    'Write unit test named : '.$testName
                );
            }
        }

        return $this->response($errors);
    }
}
