<?php

namespace RobinThijsen\LaravelMonday\Classes;

class MondayBoard extends MondayInstance
{
    public const ARGUMENTS = [
        'ids'           => null,
        'limit'         => 25,
        'page'          => 1,
        'board_king'    => null,
        'workspace_ids' => null,
        'order_by'      => null,
        'state'         => 'active', // ['all', 'active', 'archived', 'deleted'];
    ];

    public const FIELDS = [
        'id',
        'name',
        'type',
        'description',
        'board_folder_id',
        'board_kind',
        'workspace_id',
        'workspace',   // ->workspace()
        'creator',     // ->creator()
        'owners',      // ->owners()
//        'team_owners',
        'url',
//        'tags',
        'state',
//        'views',       // ->views()
        'subscribers', // ->subscribers()
//        'team_subscribers',
        'columns',     // ->columns()
        'communication',
//        'groups',      // ->groups()
        'items_count',
//        'items_page',  // ->items()
        'item_terminology',
//        'top_group',   // ->group()
//        'updates',
        'updated_at',
//        'activity_logs',
    ];

    public ?int $id = null;
    public ?string $name = null;
    public ?string $type = null;
    public ?string $description = null;
    public ?string $board_folder_id = null;
    public ?string $board_kind = null;
    public ?int $workspace_id = null;
    public ?MondayWorkspace $workspace = null;
    public ?MondayAccount $creator = null;
    public ?array $owners = null;
    public ?array $team_owners = null;
    public ?string $url = null;
    public ?array $tags = null;
    public ?string $state = null;
    public ?array $subscribers = null;
    public ?array $team_subscribers = null;
    public ?array $columns = null;
    public ?string $communication = null;
    public ?array $groups = null;
    public ?int $items_count = null;
    public ?array $items_page = null;
    public ?string $item_terminology = null;
    public ?MondayGroup $top_group = null;
    public ?array $views = null;
    public ?array $updates = null;
    public ?string $updated_at = null;
    public ?array $activity_logs = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            switch ($key) {
                case "groups":
                    foreach ($value as $group)
                        $this->groups[] = new MondayGroup($group);
                    break;
                case "subscribers":
                    foreach ($value as $subscriber)
                        $this->groups[] = new MondayAccount($subscriber);
                    break;
                case "items_page":
                    foreach ($value as $itemPage)
                        $this->items_page[] = new MondayItemPage($itemPage);
                    break;
                case "creator":
                    $this->{$key} = new MondayAccount($value);
                    break;
                case "workspace":
                    $this->{$key} = new MondayWorkspace($value);
                    break;
                case "top_group":
                    $this->{$key} = new MondayGroup($value);
                    break;
                default:
                    $this->{$key} = $value;
                    break;
            }
        }
    }
}
