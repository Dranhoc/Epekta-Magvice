<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SignedMediaController extends Controller
{
    public function __invoke(string $uuid)
    {
        $media = Media::where('uuid', $uuid)->firstOrFail();

        return Storage::disk($media->disk)
            ->download($media->getPathRelativeToRoot(), $media->file_name);
    }
}
