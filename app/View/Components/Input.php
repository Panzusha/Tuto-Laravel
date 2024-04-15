<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    /**
     * Create a new component instance.
     */
    // propriétés pour le formulaire de input.blade.php
    // $name et $label sont les seules a être obligatoire
    public function __construct(
        public string $name,
        public string $label,
        // typage, soit une chaine de caractères soit null
        public ?string $value = null,
        public ?string $id = null, 
        public string $type = 'text',
        public string $help = '',
    )
    {
        // $this->id = $this->id ?? $this->name;      variante
        // si $this->id est égale a null (s'il n y en a pas), elle prendra la valeur de $name
        $this->id ??= $this->name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
