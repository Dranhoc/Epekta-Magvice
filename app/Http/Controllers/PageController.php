<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $page = Page::where('slug->fr', 'home')->firstOrNew();

        return view('pages.home')->with([
            'page' => $page,
        ]);
    }

    public function render(Request $request): View
    {
        $page = $this->loadPage($request);

        $view = $page->template ?? 'static';

        /** @var array<mixed, mixed>|View $data_from_specific_method */
        $data_from_specific_method = $page->method && method_exists($this, $page->method) ? $this->{$page->method}($request) : [];

        if (is_object($data_from_specific_method)) {
            return $data_from_specific_method;
        }

        return view("pages.{$view}")->with(
            array_merge(
                [
                    'page' => $page,
                ],
                $data_from_specific_method
            )
        );
    }

    public function admin(): View
    {
        return view('pages.admin');
    }
}
