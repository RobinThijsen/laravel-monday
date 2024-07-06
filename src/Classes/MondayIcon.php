<?php

namespace RobinThijsen\LaravelMonday\Classes;

class MondayIcon extends MondayInstance
{
    public const FIELDS = [
        'color',
        'image',
    ];

    public ?string $color = null;

    public ?string $image = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
