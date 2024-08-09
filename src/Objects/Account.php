<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;
use RobinThijsen\LaravelMonday\Builder\BuilderParams;
use RobinThijsen\LaravelMonday\Builder\Type\BuilderParamTypes;
use RobinThijsen\LaravelMonday\LaravelMonday;
use RobinThijsen\LaravelMonday\Objects\Assets\BoardKind;
use RobinThijsen\LaravelMonday\Objects\Assets\State;

#[\AllowDynamicProperties]
class Account extends Builder
{
    protected const PARAMS = [];
    protected const DEFAULT_FIELDS = [
        'active_members_count',
        'country_code',
        'first_day_of_the_week',
        'id',
        'logo',
        'name',
        'show_timeline_weekends',
        'sign_up_product_kind',
        'slug',
        'tier',
    ];
    protected const OBJECT_FIELDS = [
        'products',
    ];
    protected const UNIQUE_OBJECT_FIELDS = [
        'plan',
    ];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "account";
    protected $objectNamePlural = "accounts";
    protected static $idType = BuilderParamTypes::INT;

    public function __construct($params = null, $isUnique = false)
    {
        parent::__construct($params, $isUnique);
    }
}
