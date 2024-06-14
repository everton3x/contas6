<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Periodo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?string $label = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input.periodo');
    }
}
