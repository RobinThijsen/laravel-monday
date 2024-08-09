<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\BuilderParams;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;

#[\AllowDynamicProperties]
class Item extends Builder
{
    protected const PARAMS = [
        'ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
        'limit' => BuilderParamTypes::INT,
        'page' => BuilderParamTypes::INT,
        'newest_first' => BuilderParamTypes::BOOL,
        'exclude_nonactive' => BuilderParamTypes::BOOL,
    ];
    protected const DEFAULT_FIELDS = [
        'created_at',
        'creator_id',
        'email',
        'id',
        'name',
        'relative_link',
        'state',
        'updated_at',
        'url',
    ];
    protected const OBJECT_FIELDS = [
        'assets',
        'column_values',
//        'linked_items',
//        'subitems',
        'subscribers',
    ];
    protected const UNIQUE_OBJECT_FIELDS = [
        'board',
        'creator',
        'group',
//        'parent_item',
    ];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "item";
    protected $objectNamePlural = "items";
    protected $idType = BuilderParamTypes::INT;

    public function __construct($params = null, $isUnique = false)
    {
        parent::__construct($params, $isUnique);
    }

    public static function query(
        $ids = null,
        $limit = 25,
        $page = 1,
        bool $newest_first = false,
        bool $exclude_nonactive = true
    ){
        $params = [];

        if ($ids) {
            is_array($ids)
                ? $params[] = new BuilderParams('ids', BuilderParamTypes::ARRAY_OF_INT, $ids)
                : $params[] = new BuilderParams('ids', BuilderParamTypes::INT, (int)$ids);
        }
        $params[] = new BuilderParams('limit', BuilderParamTypes::INT, $limit);
        $params[] = new BuilderParams('page', BuilderParamTypes::INT, $page);
        $params[] = new BuilderParams('newest_first', BuilderParamTypes::BOOL, $newest_first);
        $params[] = new BuilderParams('exclude_nonactive', BuilderParamTypes::BOOL, $exclude_nonactive);

        return new self($params);
    }

    public static function find(
        $id,
        $limit = 25,
        $page = 1,
        bool $newest_first = false,
        bool $exclude_nonactive = true
    ){
        $params = [];

        $params[] = new BuilderParams('id', BuilderParamTypes::INT, $id);
        $params[] = new BuilderParams('limit', BuilderParamTypes::INT, $limit);
        $params[] = new BuilderParams('page', BuilderParamTypes::INT, $page);
        $params[] = new BuilderParams('newest_first', BuilderParamTypes::BOOL, $newest_first);
        $params[] = new BuilderParams('exclude_nonactive', BuilderParamTypes::BOOL, $exclude_nonactive);

        return new self($params, true);
    }
}
