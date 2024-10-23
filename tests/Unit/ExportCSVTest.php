<?php

declare(strict_types=1);

use App\Actions\Export\ExportCSV;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

it('can export data from models', function () {
    $response = (new ExportCSV)->export(User::class, ['id', 'name', 'email']);

    expect($response)->toBeInstanceOf(StreamedResponse::class);
});
