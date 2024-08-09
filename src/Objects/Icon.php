<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;

#[\AllowDynamicProperties]
class Icon extends Builder
{
    protected const PARAMS = [];
    protected const DEFAULT_FIELDS = [
        'color',
        'image',
    ];
    protected const OBJECT_FIELDS = [];
    protected const UNIQUE_OBJECT_FIELDS = [];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "icon";
    protected $objectNamePlural = "icons";
    protected $idType = null;

    public function __construct($params = null)
    {
        parent::__construct($params, false);
    }
}
