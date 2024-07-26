<?php

namespace RobinThijsen\LaravelMonday\Objects;

class MondayIcon extends MondayObject
{
    // Commented fields aren't available in the fields array and should be added with the method indicated in the comment if available.
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
