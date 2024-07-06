<?php

namespace RobinThijsen\LaravelMonday\Classes;

class MondayAccount extends MondayInstance
{
    const FIELDS = ["name"];

    public string $name;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
