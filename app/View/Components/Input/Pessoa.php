<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Pessoa extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?Collection $pessoas
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input.pessoa');
    }
}
