<?php

namespace RobinThijsen\LaravelMonday\Objects;

use RobinThijsen\LaravelMonday\Builder\Builder;

#[\AllowDynamicProperties]
class WorkspaceSetting extends Builder
{
    protected const PARAMS = [];
    protected const DEFAULT_FIELDS = [];
    protected const OBJECT_FIELDS = [];
    protected const UNIQUE_OBJECT_FIELDS = [
        'icon',
    ];
    protected const EXCEPTION_FIELDS = [];
    protected $objectName = "workspace_setting";
    protected $objectNamePlural = "workspace_settings";
    protected $idType = null;

    public function __construct($params = null)
    {
        parent::__construct($params, false);
    }
}
