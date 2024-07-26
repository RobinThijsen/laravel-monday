<?php

namespace RobinThijsen\LaravelMonday\Objects;

class MondayItemPage extends MondayObject
{
    public const ARGUMENTS = [
        'limit' => 25,
    ];

    // Commented fields aren't available in the fields array and should be added with the method indicated in the comment if available.
    public const FIELDS = [
//        'items', ->items() for itemsPage and items you should use items(). She automatically call items in items_page
    ];

    public ?array $items = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        if (isset($fields['items'])) {
            $fields = $fields['items'];
        }

        foreach ($fields as $value) {
            $this->items[] = new MondayItem($value);
        }
    }
}
