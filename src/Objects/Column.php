<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;

#[\AllowDynamicProperties]
class Column extends Builder
{
    protected const PARAMS = [
        'ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
        'types' => [BuilderParamTypes::ARRAY_OF_ELEMENT, BuilderParamTypes::ELEMENT],
    ];
    protected const DEFAULT_FIELDS = [
        'id',
        'title',
        'description',
        'type',
        'archived',
        'width',
        'setttings_str',
    ];
    protected const OBJECT_FIELDS = [];
    protected const UNIQUE_OBJECT_FIELDS = [];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "column";
    protected $objectNamePlural = "columns";
    protected $idType = BuilderParamTypes::STRING;

    public function __construct($params = null)
    {
        parent::__construct($params, false);
    }
}
