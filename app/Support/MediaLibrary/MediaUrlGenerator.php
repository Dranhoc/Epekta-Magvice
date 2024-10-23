<?php

declare(strict_types=1);

namespace App\Support\MediaLibrary;

use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

class MediaUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        if ($this->media->disk === 'private') {
            return URL::signedRoute('media', $this->media->uuid, now()->addYear());
        }

        return parent::getUrl();
    }
}
