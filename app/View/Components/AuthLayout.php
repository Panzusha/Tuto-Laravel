<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;

class AuthLayout extends AbstractLayout
{
    // surcharge du constructeur (obtenu de la classe parente) pour se conformer au besoin du formulaire inscription
    public function __construct(
        public string $title = '',
        public string $action = '',
        public string $submitMessage = 'Soumettre',
    )
    {
        parent::__construct($title);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.auth');
    }
}
