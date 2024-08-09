<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\BuilderParams;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;

#[\AllowDynamicProperties]
class Team extends Builder
{
    protected const PARAMS = [
        'ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
    ];
    protected const DEFAULT_FIELDS = [
        'id',
        'name',
        'picture_url',
    ];
    protected const OBJECT_FIELDS = [
        'owners',
        'users',
    ];
    protected const UNIQUE_OBJECT_FIELDS = [];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "team";
    protected $objectNamePlural = "teams";
    protected static $idType = BuilderParamTypes::INT;

    public function __construct($params = null, $isUnique = false)
    {
        parent::__construct($params, $isUnique);
    }

    public static function query(
        $ids = null,
    ){
        $params = [];

        if ($ids) {
            is_array($ids)
                ? $params[] = new BuilderParams('ids', BuilderParamTypes::ARRAY_OF_INT, $ids)
                : $params[] = new BuilderParams('ids', BuilderParamTypes::INT, (int)$ids);
        }

        return new self($params);
    }

    public static function find(
        $id,
    ){
        $params = [];

        $params[] = new BuilderParams('ids', BuilderParamTypes::INT, $id);

        return new self($params, true);
    }
}
