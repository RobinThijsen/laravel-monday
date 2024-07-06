<?php

namespace RobinThijsen\LaravelMonday\Commands;

use Illuminate\Console\Command;

class LaravelMondayCommand extends Command
{
    public $signature = 'larave-monday';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
