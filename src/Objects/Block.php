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
class Block extends Builder
{
    protected const PARAMS = [
        'limit' => BuilderParamTypes::INT,
        'page' => BuilderParamTypes::INT,
    ];
    protected const DEFAULT_FIELDS = [
        'content',
        'created_at',
        'doc_id',
        'id',
        'parent_block_id',
        'type',
        'updated_at',
    ];
    protected const OBJECT_FIELDS = [];
    protected const UNIQUE_OBJECT_FIELDS = [
        'created_by',
    ];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "block";
    protected $objectNamePlural = "blocks";
    protected static $idType = BuilderParamTypes::STRING;

    public function __construct($params = null, $isUnique = false)
    {
        parent::__construct($params, $isUnique);
    }

    public static function query(
        $limit = 25,
        $page = 1,
    ){
        $params = [];

        $params[] = new BuilderParams('limit', BuilderParamTypes::INT, $limit);
        $params[] = new BuilderParams('page', BuilderParamTypes::INT, $page);

        return new self($params);
    }
}
