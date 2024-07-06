<?php

namespace RobinThijsen\LaravelMonday\Classes;

class MondayBlock extends MondayInstance
{
    const ARGUMENTS = ['limit' => 25, 'page' => 1];

    // Commented fields aren't available in the fields array and should be added with the method indicated in the comment if available.
    const FIELDS = [
        'id',
        'doc_id',
        'parent_block_id',
        'position',
        'type',
        'content',
        'created_at',
        'updated_at',
//        'created_by', // ->creator()
    ];

    public ?string $id = null;

    public ?int $doc_id = null;

    public ?string $parent_block_id = null;

    public ?float $position = null;

    public ?string $type = null;

    public mixed $content = null;

    public ?string $created_at = null;

    public ?string $updated_at = null;

    public ?MondayAccount $created_by = null;

    public function __construct(array $fields)
    {
        parent::__construct();

        foreach ($fields as $key => $value) {
            $this->{$key} = match ($key) {
                'content' => json_decode($value),
                'created_by' => new MondayAccount($value),
                default => $value,
            };
        }
    }
}
