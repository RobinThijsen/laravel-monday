<?php

namespace RobinThijsen\LaravelMonday\Builder;

class BuilderFields
{
    public $name;
    public $type;
    public $className;
    public $parentClassName;
    public $params;
    public $fields;
    public $isAlreadyInitialized = false;

    public function __construct($name, $type, $className = null, $parentClassName = null, $params = [], $fields = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->className = $className;
        $this->parentClassName = $parentClassName;
        $this->params = $params;
        $this->fields = $fields;
    }
}
