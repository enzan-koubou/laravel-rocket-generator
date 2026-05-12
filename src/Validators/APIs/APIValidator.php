<?php

namespace EnzanRocket\Generator\Validators\APIs;

use EnzanRocket\Generator\Validators\BaseValidator;

class APIValidator extends BaseValidator
{
    /**
     * @param \EnzanRocket\Generator\Objects\OpenAPI\OpenAPISpec $spec
     * @param \EnzanRocket\Generator\Objects\Definitions         $json
     *
     * @return array
     */
    public function validate($spec, $json)
    {
        $success = true;
        $errors  = [];

        return [$success, $errors];
    }
}
