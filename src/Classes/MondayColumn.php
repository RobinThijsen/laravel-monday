<?php

namespace RobinThijsen\LaravelMonday\Classes;

class MondayColumn extends MondayInstance
{
    public const ARGUMENTS = [
        'ids' => null,
        'types' => null, // ["name", "file", "people", "date", "status"]
    ];

    // Commented fields aren't available in the fields array and should be added with the method indicated in the comment if available.
    public const FIELDS = [
        'id',
        'title',
        'description',
        'type',
        'width',
        'archived',
        'settings_str',
    ];

    public ?int $id = null;

    public ?string $title = null;

    public ?string $description = null;

    public ?string $type = null;

    public ?float $width = null;

    public ?bool $archived = null;

    public ?array $settings_str = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            $this->{$key} = match ($key) {
                'settings_str' => json_decode($value),
                default => $value,
            };
        }
    }
}
