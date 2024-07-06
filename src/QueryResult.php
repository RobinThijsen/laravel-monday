<?php

namespace RobinThijsen\LaravelMonday;

use RobinThijsen\LaravelMonday\Classes\MondayBoard;
use RobinThijsen\LaravelMonday\Classes\MondayDoc;
use RobinThijsen\LaravelMonday\Classes\MondayWorkspace;

class QueryResult
{
    public ?array $docs = null;

    public ?array $boards = null;

    public ?array $workspaces = null;

    public ?array $errors = null;

    public ?int $countOfOpenBrackets;
    public ?int $countOfCloseBrackets;

    private string $query;

    public function __construct(array $result, string $query)
    {
        $this->query = $query;
        $this->countOfOpenBrackets = substr_count($query, '{');
        $this->countOfCloseBrackets = substr_count($query, '}');

        if (isset($result['docs'])) {
            foreach ($result['docs'] as $doc) {
                $this->docs[] = new MondayDoc($doc);
            }
        }

        if (isset($result['boards'])) {
            foreach ($result['boards'] as $board) {
                $this->boards[] = new MondayBoard($board);
            }
        }

        if (isset($result['workspaces'])) {
            foreach ($result['workspaces'] as $workspace) {
                $this->workspaces[] = new MondayWorkspace($workspace);
            }
        }

        if (isset($result[0]['message']) && isset($result[0]['locations'])) {
            $this->errors = $result;
        }
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}
