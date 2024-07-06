<?php

namespace RobinThijsen\LaravelMonday\Classes;

class MondayGroup extends MondayInstance
{
    public const ARGUMENTS = [
        'ids' => null,
    ];

    // Commented fields aren't available yet
    public const FIELDS = [
        'id',
        'title',
        'position',
        'color',
        'items_page',
        'archived',
        'deleted',
    ];

    public ?int $id = null;
    public ?string $title = null;
    public ?int $position = null;
    public ?string $color = null;
    public ?array $items_page = null;
    public ?bool $archived = null;
    public ?bool $deleted = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            switch ($key) {
                case "items_page":
                    $this->{$key}[] = new MondayItemPage($value);
                    break;
                default:
                    $this->{$key} = $value;
                    break;
            }
        }
    }
}
