<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\BuilderParams;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;
use RobinThijsen\LaravelMonday\Objects\Assets\State;
use RobinThijsen\LaravelMonday\Objects\Assets\WorkspaceKind;
use RobinThijsen\LaravelMonday\Objects\Assets\WorkspaceOrderBy;

#[\AllowDynamicProperties]
class Workspace extends Builder
{
    protected const PARAMS = [
        'ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
        'kind' => BuilderParamTypes::ELEMENT,
        'limit' => BuilderParamTypes::INT,
        'page' => BuilderParamTypes::INT,
        'state' => BuilderParamTypes::ELEMENT,
        'order_by' => BuilderParamTypes::ELEMENT,
    ];
    protected const DEFAULT_FIELDS = [
        'created_at',
        'description',
        'id',
        'is_default_workspace',
        'kind',
        'name',
        'state',
    ];
    protected const OBJECT_FIELDS = [
        'account_product',
    ];
    protected const UNIQUE_OBJECT_FIELDS = [
        'owners_subscribers',
        'settings',
        'team_owners_subscribers',
        'teams_subscribers',
        'users_subscribers',
    ];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "workspace";
    protected $objectNamePlural = "workspaces";
    protected $idType = BuilderParamTypes::INT;

    public function __construct($params = null, $isUnique = false)
    {
        parent::__construct($params, $isUnique);
    }

    public static function query(
        $ids = null,
        $kind = WorkspaceKind::OPEN,
        $limit = 25,
        $page = 1,
        $state = State::ACTIVE,
        $order_by = WorkspaceOrderBy::CREATED_AT,
    ) {
        $params = [];

        if ($ids) {
            is_array($ids)
                ? $params[] = new BuilderParams('ids', BuilderParamTypes::ARRAY_OF_INT, $ids)
                : $params[] = new BuilderParams('ids', BuilderParamTypes::INT, (int)$ids);
        }
        $params[] = new BuilderParams('kind', BuilderParamTypes::ELEMENT, $kind);
        $params[] = new BuilderParams('limit', BuilderParamTypes::INT, $limit);
        $params[] = new BuilderParams('page', BuilderParamTypes::INT, $page);
        $params[] = new BuilderParams('state', BuilderParamTypes::ELEMENT, $state);
        $params[] = new BuilderParams('order_by', BuilderParamTypes::ELEMENT, $orderBy);

        return new self($params);
    }

    public static function find(
        $id,
        $kind = WorkspaceKind::OPEN,
        $limit = 25,
        $page = 1,
        $state = State::ACTIVE,
        $order_by = WorkspaceOrderBy::CREATED_AT,
    ){
        $params = [];

        $params[] = new BuilderParams('ids', BuilderParamTypes::INT, $id);
        $params[] = new BuilderParams('kind', BuilderParamTypes::INT, $kind);
        $params[] = new BuilderParams('limit', BuilderParamTypes::INT, $limit);
        $params[] = new BuilderParams('page', BuilderParamTypes::INT, $page);
        $params[] = new BuilderParams('state', BuilderParamTypes::ELEMENT, $state);
        $params[] = new BuilderParams('order_by', BuilderParamTypes::ELEMENT, $order_by);

        return new self($params, true);
    }
}
