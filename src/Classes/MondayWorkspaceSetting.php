<?php

namespace RobinThijsen\LaravelMonday\Classes;

class MondayWorkspaceSetting extends MondayInstance
{
    public const FIELDS = [
        'icon',
    ];

    public ?MondayIcon $icon = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            $this->{$key} = new MondayIcon($value);
        }
    }
}
