<?php

declare(strict_types=1);

namespace App\Console\Commands\Utils;

use App\Models\Content;
use Exception;
use Illuminate\Console\Command;

class ContentsCleanCommand extends Command
{
    protected $signature = 'app:utils:contents:clean {name?}';

    protected $description = 'Clean contents';

    public function handle(): void
    {
        throw_if(app()->environment('local') === false, new Exception('Only for local env !'));

        Content::when($this->argument('name'), static fn ($query, $value) => $query->where('name', $value))
            ->get()
            ->each(fn (Content $content) => $content->delete());
    }
}
