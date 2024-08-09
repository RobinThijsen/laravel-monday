<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\BuilderParams;
use RobinThijsen\LaravelMonday\Builder\Query;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;
use RobinThijsen\LaravelMonday\LaravelMonday;
use RobinThijsen\LaravelMonday\Objects\Assets\BoardKind;
use RobinThijsen\LaravelMonday\Objects\Assets\State;

#[\AllowDynamicProperties]
class Board extends Builder
{
    protected const PARAMS = [
        'ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
        'workspace_ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
        'limit' => BuilderParamTypes::INT,
        'page' => BuilderParamTypes::INT,
        'board_kind' => BuilderParamTypes::ELEMENT,
        'state' => BuilderParamTypes::ELEMENT,
    ];
    protected const DEFAULT_FIELDS = [
        'board_folder_id',
        'board_kind',
        'communication',
        'description',
        'id',
        'item_terminology',
        'items_count',
        'name',
        'permissions',
        'state',
        'tags',
        'type',
        'updated_at',
        'url',
        'workspace_id',
    ];
    protected const OBJECT_FIELDS = [
        'columns',
        'groups',
        'items_page',
        'items',
        'owners',
        'team_owners',
        'team_subscribers',
        'views',
    ];
    protected const UNIQUE_OBJECT_FIELDS = [
        'creator',
        'top_group',
        'workspace',
    ];
    protected const EXCEPTION_FIELDS = [
        'items_page' => 'items',
    ];
    protected $objectName = "board";
    protected $objectNamePlural = "boards";
    protected static $idType = BuilderParamTypes::INT;

    public function __construct($params = null, $isUnique = false)
    {
        parent::__construct($params, $isUnique);
    }

    public static function query(
        $ids = null,
        $workspaceIds = null,
        $limit = 25,
        $page = 1,
        $boardKind = BoardKind::PUBLIC,
        $boardState = State::ACTIVE
    ){
        $params = [];

        if ($ids) {
            is_array($ids)
                ? $params[] = new BuilderParams('ids', BuilderParamTypes::ARRAY_OF_INT, $ids)
                : $params[] = new BuilderParams('ids', BuilderParamTypes::INT, (int)$ids);
        }
        if ($workspaceIds) {
            is_array($workspaceIds)
                ? $params[] = new BuilderParams('workspace_ids', BuilderParamTypes::ARRAY_OF_INT, $workspaceIds)
                : $params[] = new BuilderParams('workspace_ids', BuilderParamTypes::INT, (int)$workspaceIds);
        }
        $params[] = new BuilderParams('limit', BuilderParamTypes::INT, $limit);
        $params[] = new BuilderParams('page', BuilderParamTypes::INT, $page);
        $params[] = new BuilderParams('board_kind', BuilderParamTypes::ELEMENT, $boardKind);
        $params[] = new BuilderParams('state', BuilderParamTypes::ELEMENT, $boardState);

        return new self($params);
    }

    public static function find(
        $id,
        $workspaceIds = null,
        $limit = 25,
        $page = 1,
        $boardKind = BoardKind::PUBLIC,
        $boardState = State::ACTIVE
    ){
        $params = [];

        if ($workspaceIds) {
            is_array($workspaceIds)
                ? $params[] = new BuilderParams('workspace_ids', BuilderParamTypes::ARRAY_OF_INT, $workspaceIds)
                : $params[] = new BuilderParams('workspace_ids', BuilderParamTypes::INT, (int)$workspaceIds);
        }
        $params[] = new BuilderParams('ids', BuilderParamTypes::INT, $id);
        $params[] = new BuilderParams('limit', BuilderParamTypes::INT, $limit);
        $params[] = new BuilderParams('page', BuilderParamTypes::INT, $page);
        $params[] = new BuilderParams('board_kind', BuilderParamTypes::ELEMENT, $boardKind);
        $params[] = new BuilderParams('state', BuilderParamTypes::ELEMENT, $boardState);

        return new self($params, true);
    }

    private static function create(array $params = ['name' => 'New Board', 'kind' => BoardKind::PUBLIC], array $fields = ['id', 'name']): self
    {
        $laravelMonday = new LaravelMonday();
        $newBoard = new self;

        $query = 'create_board (board_name: "' . $params['name'] . '", board_kind: ' . $params['kind'] . ') { ' . implode(' ', $fields);
        $query = parent::end($query);

        $result = $laravelMonday->queryResult($query, LaravelMonday::MUTATION);
        parent::initObjectProps($newBoard, $result['create_board']);

        return $newBoard;
    }
}
