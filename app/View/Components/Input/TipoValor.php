<?php

namespace App\View\Components\Input;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TipoValor extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?string $option = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input.tipo-valor');
    }

    public function isChecked(string $option): bool
    {
        return $option === $this->option;
    }
}
