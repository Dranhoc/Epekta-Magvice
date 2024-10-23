<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\Robots;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class SEOController extends Controller
{
    public function robots(Robots $robots): \Illuminate\Contracts\Foundation\Application|ResponseFactory|Application|Response
    {
        $robots->addUserAgent('*');

        if (! App::environment('production')) {
            $robots->addDisallow('/');

            return response($robots->generate(), 200, ['Content-Type' => 'text/plain']);
        }

        $robots->addDisallow('/admin');
        $robots->addDisallow('/index.php');
        $robots->addSitemap(url('sitemap.xml'));

        return response($robots->generate(), 200, ['Content-Type' => 'text/plain']);
    }
}
