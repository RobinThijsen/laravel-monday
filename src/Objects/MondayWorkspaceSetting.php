<?php

namespace RobinThijsen\LaravelMonday\Objects;

class MondayWorkspaceSetting extends MondayObject
{
    // Commented fields aren't available in the fields array and should be added with the method indicated in the comment if available.
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
