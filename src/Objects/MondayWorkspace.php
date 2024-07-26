<?php

namespace RobinThijsen\LaravelMonday\Objects;

class MondayWorkspace extends MondayObject
{
    public const ARGUMENTS = [
        'ids' => null,
        'limit' => 25,
        'page' => 1,
        'kind' => null,     // ['open', 'closed']
        'state' => 'active', // ['all', 'active', 'archived', 'deleted'];
        'order_by' => null,
    ];

    // Commented fields aren't available in the fields array and should be added with the method indicated in the comment if available.
    public const FIELDS = [
        'id',
        'name',
        'description',
        'state',
        'kind',
//        "account_product",
        'is_default_workspace',
//        'owners_subscribers', // ->ownersSubscribers()
//        'users_subscribers',  // ->usersSubscribers()
//        'settings',           // ->settings()->icon()
    ];

    public ?int $id = null;

    public ?string $name = null;

    public ?string $description = null;

    public ?string $state = null;

    public ?string $kind = null;

    public ?string $account_product = null;

    public ?bool $is_default_workspace = null;

    public ?array $owners_subscribers = null;

    public ?array $users_subscribers = null;

    public ?MondayWorkspaceSetting $settings = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            switch ($key) {
                case 'owners_subscribers':
                    foreach ($value as $ownersSubscriber) {
                        $this->owners_subscribers[] = new MondayAccount($ownersSubscriber);
                    }
                    break;
                case 'users_subscribers':
                    foreach ($value as $usersSubscriber) {
                        $this->users_subscribers[] = new MondayAccount($usersSubscriber);
                    }
                    break;
                case 'settings':
                    $this->{$key} = new MondayWorkspaceSetting($value);
                    break;
                default:
                    $this->{$key} = $value;
                    break;
            }
        }
    }
}
