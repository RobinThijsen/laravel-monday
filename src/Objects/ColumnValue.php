<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;

#[\AllowDynamicProperties]
class ColumnValue extends Builder
{
    protected const PARAMS = [
        'ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
        'types' => [BuilderParamTypes::ARRAY_OF_ELEMENT, BuilderParamTypes::ELEMENT],
    ];
    protected const DEFAULT_FIELDS = [
        'id',
        'text',
        'value',
        'type',
    ];
    protected const OBJECT_FIELDS = [];
    protected const UNIQUE_OBJECT_FIELDS = [
        'column'
    ];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "column_value";
    protected $objectNamePlural = "column_values";
    protected $idType = BuilderParamTypes::STRING;

    public function __construct($params = null)
    {
        parent::__construct($params, false);
    }
}
