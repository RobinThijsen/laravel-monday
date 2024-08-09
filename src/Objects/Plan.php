<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\BuilderParams;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;
use RobinThijsen\LaravelMonday\LaravelMonday;
use RobinThijsen\LaravelMonday\Objects\Assets\BoardKind;
use RobinThijsen\LaravelMonday\Objects\Assets\Kind;
use RobinThijsen\LaravelMonday\Objects\Assets\State;

#[\AllowDynamicProperties]
class Plan extends Builder
{
    protected const PARAMS = [];
    protected const DEFAULT_FIELDS = [
        'version',
        'tier',
        'period',
        'max_users',
    ];
    protected const OBJECT_FIELDS = [];
    protected const UNIQUE_OBJECT_FIELDS = [];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "plan";
    protected $objectNamePlural = "plans";
    protected static $idType = null;

    public function __construct($params = null)
    {
        parent::__construct($params, false);
    }
}
