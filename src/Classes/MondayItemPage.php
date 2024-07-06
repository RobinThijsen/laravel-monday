<?php

namespace RobinThijsen\LaravelMonday\Classes;

class MondayItemPage extends MondayInstance
{
    public const ARGUMENTS = [
        'limit' => 25,
    ];

    // Commented fields aren't available yet
    public const FIELDS = [
        'items',
    ];

    public function __construct(array $value)
    {
        parent::__construct();
    }
}
