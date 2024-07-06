<?php

namespace RobinThijsen\LaravelMonday\Classes;

class MondayDoc extends MondayInstance
{
    public const ARGUMENTS = [
        'ids' => null,
        'limit' => 25,
        'page' => 1,
        'object_ids' => null,
        'workspace_ids' => null,
        'order_by' => null,
    ];

    public const FIELDS = [
        'id',
        'name',
        'object_id',
        'url',
        'relative_url',
        'doc_kind',
        'doc_folder_id',
        'workspace_id',
        'workspace',  // ->workspace()
        'created_by', // ->creator()
        'created_at',
        'blocks',     // ->blocks()
        'settings',
    ];

    public ?int $id = null;

    public ?string $name = null;

    public ?string $object_id = null;

    public ?string $url = null;

    public ?string $relative_url = null;

    public ?string $doc_king = null;

    public ?string $doc_folder_id = null;

    public ?string $workspace_id = null;

    public ?MondayWorkspace $workspace = null;

    public ?MondayAccount $created_by = null;

    public ?string $created_at = null;

    public ?array $blocks = null;

    public ?array $settings = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            switch ($key) {
                case 'blocks':
                    foreach ($value as $block) {
                        $this->blocks[] = new MondayBlock($block);
                    }
                    break;
                case 'created_by':
                    $this->{$key} = new MondayAccount($value);
                    break;
                case 'workspace':
                    $this->{$key} = new MondayWorkspace($value);
                    break;
                case 'settings':
                    $this->{$key} = json_decode($value);
                    break;
                default:
                    $this->{$key} = $value;
                    break;
            }
        }
    }
}
