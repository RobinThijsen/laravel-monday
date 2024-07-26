<?php

namespace RobinThijsen\LaravelMonday\Objects;

class MondayColumnValue extends MondayObject
{
    public const ARGUMENTS = [
        'ids' => null,
        'types' => null, // ["name", "file", "people", "date", "status"]
    ];

    // Commented fields aren't available in the fields array and should be added with the method indicated in the comment if available.
    public const FIELDS = [
        'id',
        'text',
        'type',
//        'column', // ->column()
        'value',
    ];

    public ?int $id = null;

    public ?string $text = null;

    public ?string $type = null;

    public ?MondayColumn $column = null;

    public ?array $value = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            $this->{$key} = match ($key) {
                'column' => new MondayColumn($value),
                'value' => json_decode($value),
                default => $value,
            };
        }
    }
}
