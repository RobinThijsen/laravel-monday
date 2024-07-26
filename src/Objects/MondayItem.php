<?php

namespace RobinThijsen\LaravelMonday\Objects;

class MondayItem extends MondayObject
{
    public const ARGUMENTS = [
        'ids' => null,
        'limit' => 25,
        'page' => 1,
        'newest_first' => null,
        'exclude_nonactive' => null,
    ];

    // Commented fields aren't available in the fields array and should be added with the method indicated in the comment if available.
    public const FIELDS = [
        'id',
        'name',
//        'board', // ->board()
//        'parent_item', // ->parentItem()
//        'subitems', // ->subitems()
        'url',
        'relative_link',
//        'group', // ->group()
        'email',
        'creator_id',
//        'creator', // ->creator()
//        'subscribers', // ->subscribers()
//        'column_values',
//        'assets',
        'state',
//        'updates',
        'created_at',
        'updated_at',
    ];

    public ?int $id = null;
    public ?string $name = null;
    public ?MondayBoard $board = null;
    public ?MondayItem $parent_item = null;
    public ?array $subitems = null;
    public ?string $url = null;
    public ?string $relative_link = null;
    public ?MondayGroup $group = null;
    public ?string $email = null;
    public ?string $creator_id = null;
    public ?MondayAccount $creator = null;
    public ?array $subscribers = null;
//    public ?MondayColumnValue $column_values = null;
//    public ?array $assets = null;
    public ?string $state = null;
//    public ?array $updates = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            switch ($key) {
                case "board":
                    $this->{$key} = new MondayBoard($value);
                    break;
                case "parent_item":
                    $this->{$key} = new MondayItem($value);
                    break;
                case "subitems":
                    foreach ($value as $subitem) {
                        $this->{$key}[] = new MondayItem($subitem);
                    }
                    break;
                case "group":
                    $this->{$key} = new MondayGroup($value);
                    break;
                case "creator":
                    $this->{$key} = new MondayAccount($value);
                    break;
                case "subscribers":
                    foreach ($value as $subscriber) {
                        $this->{$key}[] = new MondayAccount($subscriber);
                    }
                    break;
                default:
                    $this->{$key} = $value;
                    break;
            }
        }
    }
}
