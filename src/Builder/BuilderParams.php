<?php

namespace RobinThijsen\LaravelMonday\Builder;

class BuilderParams
{
    public string $name;
    public string $type;
    public mixed $value = null;

    public function __construct(string $name, string $type, mixed $value = null)
    {
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
    }
}
