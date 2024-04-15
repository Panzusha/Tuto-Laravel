<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    // booléen utilisé plus bas dans la fonction handleValue, égale a true si valeur est une collection
    // servira a adapter l'affichage selon si on a plusieurs éléments a choisir dans le select ou pas
    public bool $valueIsCollection;

    /**
     * Create a new component instance.
     */
    public function __construct(
        // name label et list sont les propriétés où l'on sera obligé de renseigner des valeurs
        public string $name,
        public string $label,
        // devra être une collection qui contiendra la liste des éléments qui seront dans le select
        public Collection $list,
        // typage, soit une chaine de caractères soit null
        public ?string $id = null, 
        // valeur réelle de l'option 
        public string $optionsValues = 'id',
        // valeur texte correspondante (a l'id) qui sera affichée
        public string $optionsTexts = 'name',
        // une ou plusieurs valeurs choisie(s) dans le select ( peut être de plusieurs types d'où le mixed)
        public mixed $value = null,
        // pour savoir si on est sur un select a choix multiple ou pas (false/non par défaut)
        public bool $multiple = false,
        public string $help = '',
    )
    {
        // $this->id = $this->id ?? $this->name;      variante
        // si $this->id est égale a null (s'il n y en a pas), elle prendra la valeur de $name
        $this->id ??= $this->name;
        // voir fonction handleValue en dessous
        $this->handleValue();
    }

    protected function handleValue(): void
    {
        // si une valeur est déjà présente (old) on la prend ( par exemple s'il y a eu une erreur dans un autre champ
        // lors de la soumission du formulaire ) sinon on prend la nouvelle
        $this->value = old($this->name) ?? $this->value;
        // si la valeur est un tableau, on la transforme en collection
        if (is_array($this->value)) {
            $this->value = collect($this->value);
        }

        // après que le tableau value ait été transformé en collection dans le if
        // on regarde si la valeur est une instance de Collection
        $this->valueIsCollection = $this->value instanceof Collection;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}
