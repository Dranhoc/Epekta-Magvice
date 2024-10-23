<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemapCommand extends Command
{
    // TODO: test sitemaps generation
    /** @var string */
    protected $signature = 'sitemap:generate';

    /** @var string */
    protected $description = 'Generate sitemap';

    public function handle(): void
    {
        $this->generateSitemap();
    }

    protected function generateSitemap(): bool
    {
        $filenameSitemapIndex = 'sitemap.xml';
        $folderNameSitemap = 'sitemaps/';

        $pathFolderSitemap = public_path($folderNameSitemap);

        if (! File::exists($pathFolderSitemap)) {
            File::makeDirectory($pathFolderSitemap);
        }

        $locales = config('laravellocalization.localesOrder');

        $models = config('slym.sitemap');

        $oSitemapIndex = SitemapIndex::create();

        foreach ($locales as $locale) {
            $lastModification = Carbon::now();

            $oSitemap = Sitemap::create();

            foreach ($models as $model => $options) {
                foreach ($model::all() as $item) {
                    if (isset($item->is_sitemap) && $item->is_sitemap === 0) {
                        continue;
                    }

                    $oSitemap->add(
                        Url::create($item->getUrl($locale))
                            ->setPriority($options['priority'] ?? 0.9)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                            ->setLastModificationDate($item->updated_at ?? $item->created_at ?? now())
                    );

                    if ($lastModification < $item->updated_at) {
                        $lastModification = $item->updated_at;
                    }
                }
            }

            $pathSitemap = $folderNameSitemap.$locale.'_sitemap.xml';

            $oSitemap->writeToFile(public_path($pathSitemap));

            $oSitemapIndex->add(\Spatie\Sitemap\Tags\Sitemap::create($pathSitemap)->setLastModificationDate($lastModification));
        }

        $oSitemapIndex->writeToFile(public_path($filenameSitemapIndex));

        return true;
    }
}
