<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Content extends Component
{
    public ?string $name;

    public ?string $class;

    public function __construct(?string $name = null, ?string $class = null)
    {
        $this->name = $name;
        $this->class = $class;
    }

    public function render(): View
    {
        return view('app.contents.content');
    }
}
