<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\BuilderParams;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;
use RobinThijsen\LaravelMonday\LaravelMonday;
use RobinThijsen\LaravelMonday\Objects\Assets\BoardKind;
use RobinThijsen\LaravelMonday\Objects\Assets\State;

#[\AllowDynamicProperties]
class User extends Builder
{
    protected const PARAMS = [
        'ids' => [BuilderParamTypes::ARRAY_OF_INT, BuilderParamTypes::INT],
        'name' => BuilderParamTypes::STRING,
        'emails' => [BuilderParamTypes::ARRAY_OF_STRING, BuilderParamTypes::STRING],
        'limit' => BuilderParamTypes::INT,
        'page' => BuilderParamTypes::INT,
        'kind' => BuilderParamTypes::ELEMENT,
        'non_active' => BuilderParamTypes::BOOL,
        'newest_first' => BuilderParamTypes::BOOL,
    ];
    protected const DEFAULT_FIELDS = [
        'birthday',
        'country_code',
        'created_at',
        'current_language',
        'email',
        'enabled',
        'id',
        'is_admin',
        'is_guest',
        'is_pending',
        'is_verified',
        'is_view_only',
        'join_date',
        'last_activity',
        'location',
        'mobile_phone',
        'name',
        'out_of_office',
        'phone',
        'photo_original',
        'photo_small',
        'photo_thumb',
        'photo_thumb_small',
        'photo_tiny',
        'sign_up_product_kind',
        'time_zone_identifier',
        'title',
        'url',
        'utc_hours_diff',
    ];
    protected const OBJECT_FIELDS = [
        'teams',
    ];
    protected const UNIQUE_OBJECT_FIELDS = [
        'account',
    ];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "user";
    protected $objectNamePlural = "users";
    protected static $idType = BuilderParamTypes::INT;

    public function __construct($params = null, $isUnique = false)
    {
        parent::__construct($params, $isUnique);
    }
}
