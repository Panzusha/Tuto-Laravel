<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    /**
     * Create a new component instance.
     */
    // propriétés pour le formulaire de textarea.blade.php
    // $name et $label sont les seules a être obligatoire
    public function __construct(
        public string $name,
        public string $label,
        // typage, soit une chaine de caractères soit null
        public ?string $id = null, 
        public string $help = '',
    )
    {
        // si une id a été renseignée on la prend sinon (null) on utilisera la valeur de $name
        $this->id ??= $this->name;

        // $this->id = $this->id ?? $this->name;      variante
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.textarea');
    }
}
