<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\BuilderParams;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;
use RobinThijsen\LaravelMonday\LaravelMonday;
use RobinThijsen\LaravelMonday\Objects\Assets\BoardKind;
use RobinThijsen\LaravelMonday\Objects\Assets\DocOrderBy;
use RobinThijsen\LaravelMonday\Objects\Assets\State;
use RobinThijsen\LaravelMonday\Objects\Assets\WorkspaceOrderBy;

#[\AllowDynamicProperties]
class Group extends Builder
{
    protected const PARAMS = [
        'ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
    ];
    protected const DEFAULT_FIELDS = [
        'id',
        'title',
        'position',
        'color',
        'archived',
        'deleted',
    ];
    protected const OBJECT_FIELDS = [
        'items_page',
    ];
    protected const UNIQUE_OBJECT_FIELDS = [];
    protected const EXCEPTION_FIELDS = [
        'items_page' => 'items',
    ];
    protected $objectName = "group";
    protected $objectNamePlural = "groups";
    protected static $idType = BuilderParamTypes::STRING;

    public function __construct($params = null, $isUnique = false)
    {
        parent::__construct($params, $isUnique);
    }

    public static function query($ids = null){
        $params = [];

        if ($ids) {
            is_array($ids)
                ? $params[] = new BuilderParams('ids', BuilderParamTypes::ARRAY_OF_INT, $ids)
                : $params[] = new BuilderParams('ids', BuilderParamTypes::INT, (int)$ids);
        }

        return new self($params);
    }
}
