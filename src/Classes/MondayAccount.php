<?php

namespace RobinThijsen\LaravelMonday\Classes;

class MondayAccount extends MondayInstance
{
    // Commented fields aren't available in the fields array and should be added with the method indicated in the comment if available.
    const FIELDS = [
        'id',
        'name',
        'title',
        'email',
        'birthday',
        'enabled',
        'current_language',
        'is_admin',
        'is_guest',
        'is_pending',
        'is_verified',
        'is_view_only',
        'join_date',
        'location',
        'last_activity',
        'photo_original',
        'photo_small',
        'photo_tiny',
        'photo_thumb',
        'photo_thumb_small',
//        'teams',  // ->teams()
        'url',
    ];


    public ?int $id = null;
    public ?string $name = null;
    public ?string $title = null;
    public ?string $email = null;
    public ?string $birthday = null;
    public ?bool $enabled = null;
    public ?string $current_language = null;
    public ?bool $is_admin = null;
    public ?bool $is_guest = null;
    public ?bool $is_pending = null;
    public ?bool $is_verified = null;
    public ?bool $is_view_only = null;
    public ?string $join_date = null;
    public ?string $location = null;
    public ?string $last_activity = null;
    public ?string $photo_original = null;
    public ?string $photo_small = null;
    public ?string $photo_tiny = null;
    public ?string $photo_thumb = null;
    public ?string $photo_thumb_small = null;
//    public ?array $teams = null;
    public ?string $url = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
