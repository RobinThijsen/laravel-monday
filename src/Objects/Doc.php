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
class Doc extends Builder
{
    protected const PARAMS = [
        'ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
        'workspace_ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
        'object_ids' => [BuilderParamTypes::ARRAY_OF_STRING, BuilderParamTypes::STRING],
        'limit' => BuilderParamTypes::INT,
        'page' => BuilderParamTypes::INT,
        'order_by' => BuilderParamTypes::ELEMENT,
    ];
    protected const DEFAULT_FIELDS = [
        'created_at',
        'doc_folder_id',
        'doc_kind',
        'id',
        'name',
        'object_id',
        'relative_url',
        'settings',
        'url',
        'workspace_id',
    ];
    protected const OBJECT_FIELDS = [
        'blocks',
    ];
    protected const UNIQUE_OBJECT_FIELDS = [
        'created_by',
        'workspace',
    ];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "doc";
    protected $objectNamePlural = "docs";
    protected static $idType = BuilderParamTypes::INT;

    public function __construct($params = null, $isUnique = false)
    {
        parent::__construct($params, $isUnique);
    }

    public static function query(
        $ids = null,
        $workspaceIds = null,
        $objectIds = null,
        $limit = 25,
        $page = 1,
        $order_by = DocOrderBy::CREATED_AT,
    ){
        $params = [];

        if ($ids) {
            is_array($ids)
                ? $params[] = new BuilderParams('ids', BuilderParamTypes::ARRAY_OF_INT, $ids)
                : $params[] = new BuilderParams('ids', BuilderParamTypes::INT, (int)$ids);
        }
        if ($objectIds) {
            is_array($objectIds)
                ? $params[] = new BuilderParams('object_ids', BuilderParamTypes::ARRAY_OF_INT, $objectIds)
                : $params[] = new BuilderParams('object_ids', BuilderParamTypes::INT, (int)$objectIds);
        }
        if ($workspaceIds) {
            is_array($workspaceIds)
                ? $params[] = new BuilderParams('workspace_ids', BuilderParamTypes::ARRAY_OF_INT, $workspaceIds)
                : $params[] = new BuilderParams('workspace_ids', BuilderParamTypes::INT, (int)$workspaceIds);
        }
        $params[] = new BuilderParams('limit', BuilderParamTypes::INT, $limit);
        $params[] = new BuilderParams('page', BuilderParamTypes::INT, $page);
        $params[] = new BuilderParams('order_by', BuilderParamTypes::ELEMENT, $order_by);

        return new self($params);
    }

    public static function find(
        $id,
        $workspaceIds = null,
        $objectIds = null,
        $limit = 25,
        $page = 1,
        $order_by = DocOrderBy::CREATED_AT,
    ){
        $params = [];

        if ($objectIds) {
            is_array($objectIds)
                ? $params[] = new BuilderParams('object_ids', BuilderParamTypes::ARRAY_OF_INT, $objectIds)
                : $params[] = new BuilderParams('object_ids', BuilderParamTypes::INT, (int)$objectIds);
        }
        if ($workspaceIds) {
            is_array($workspaceIds)
                ? $params[] = new BuilderParams('workspace_ids', BuilderParamTypes::ARRAY_OF_INT, $workspaceIds)
                : $params[] = new BuilderParams('workspace_ids', BuilderParamTypes::INT, (int)$workspaceIds);
        }
        $params[] = new BuilderParams('ids', BuilderParamTypes::INT, $id);
        $params[] = new BuilderParams('limit', BuilderParamTypes::INT, $limit);
        $params[] = new BuilderParams('page', BuilderParamTypes::INT, $page);
        $params[] = new BuilderParams('order_by', BuilderParamTypes::ELEMENT, $order_by);

        return new self($params, true);
    }
}
