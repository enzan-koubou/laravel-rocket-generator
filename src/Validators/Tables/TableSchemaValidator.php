<?php

namespace EnzanRocket\Generator\Validators\Tables;

use EnzanRocket\Generator\Validators\BaseValidator;
use EnzanRocket\Generator\Validators\Tables\Rules\Columns\AvoidDateTime;
use EnzanRocket\Generator\Validators\Tables\Rules\Columns\AvoidLongVarChar;
use EnzanRocket\Generator\Validators\Tables\Rules\Columns\ColumnName;
use EnzanRocket\Generator\Validators\Tables\Rules\Columns\GenderWithVarChar;
use EnzanRocket\Generator\Validators\Tables\Rules\Columns\OptionDefined;
use EnzanRocket\Generator\Validators\Tables\Rules\Tables\PrimaryKeyName;
use EnzanRocket\Generator\Validators\Tables\Rules\Tables\TableName;

class TableSchemaValidator extends BaseValidator
{
    /**
     * @param \TakaakiMizuno\MWBParser\Elements\Table[]    $tables
     * @param \EnzanRocket\Generator\Objects\Definitions $json
     *
     * @return array
     */
    public function validate($tables, $json)
    {

        /** @var \EnzanRocket\Generator\Validators\BaseRule[] $tableRules */
        $tableRules = [
            new TableName(),
            new PrimaryKeyName(),
        ];

        /** @var \EnzanRocket\Generator\Validators\BaseRule[] $columnRules */
        $columnRules = [
            new ColumnName(),
            new AvoidLongVarChar(),
            new AvoidDateTime(),
            new GenderWithVarChar(),
            new OptionDefined(),
        ];

        $success = true;
        $errors  = [];

        foreach ($tables as $table) {
            foreach ($tableRules as $rule) {
                list($ruleSuccess, $ruleErrors) = $rule->validate(
                    [
                        'table'      => $table,
                        'definition' => $json ? $json->getTableDefinition($table->getName()) : [],
                        'json'       => $json,
                    ]
                );
                if (!$ruleSuccess) {
                    $success = false;
                }
                $errors = array_merge($errors, $ruleErrors);
            }

            foreach ($table->getColumns() as $column) {
                foreach ($columnRules as $rule) {
                    list($ruleSuccess, $ruleErrors) = $rule->validate(
                        [
                            'table'      => $table,
                            'column'     => $column,
                            'definition' => $json ? $json->getColumnDefinition($table->getName(), $column->getName()) : [],
                            'json'       => $json,
                        ]
                    );
                    if (!$ruleSuccess) {
                        $success = false;
                    }
                    $errors = array_merge($errors, $ruleErrors);
                }
            }
        }

        return [$success, $errors];
    }
}
