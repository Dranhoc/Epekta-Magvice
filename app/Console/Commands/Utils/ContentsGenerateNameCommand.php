<?php

namespace App\Console\Commands\Utils;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ContentsGenerateNameCommand extends Command
{
    protected $signature = 'app:utils:contents:generate-name';

    protected $description = 'Generate contents name';

    public function handle(): void
    {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(resource_path('views')));

        $files = [];

        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }

            $files[] = $file->getPathname();
        }

        foreach ($files as $file) {
            $content = file_get_contents($file);

            $pattern = '/<x-content(?!.*\bname\b)[^>]*>/i';

            $modifiedContent = preg_replace_callback($pattern, function ($matches) {
                $uuid = Str::orderedUuid()->toString();

                return str_replace('<x-content', '<x-content name="'.$uuid.'"', $matches[0]);
            }, $content);

            file_put_contents($file, $modifiedContent);
        }
    }
}
