<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PostRequest extends FormRequest
{
    // on prépare le champ slug en fonction de ce qui est rentré dedans
    protected function prepareForValidation(): void
    {
        $this->merge([
            // si le champ slug est renseigné on slugifie ce qui a été écrit, sinon on prend la valeur du champ titre
            'slug' => Str::slug($this->slug ?? $this->title),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // validation du formulaire de création de posts
    public function rules(): array
    {
        // les noms correspondent aux champs de form.blade.php
        return [
            'title' => ['required', 'string', 'between:3,255'],
            // slug unique car c'est ce qui permet (dans la barre d'adresse) de savoir a quel post on veut accéder
            'slug' => ['required', 'string', 'between:3,255', 'unique:posts'],
            'content' => ['required', 'string', 'min:10'],
            'thumbnail' => ['required', 'image'],
            // exists verifie dans la table categories, si la colonne id contient une valeur identique a celle entrée dans le formulaire
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            // tableau car plusieurs tags possibles, exists pareil que category
            'tag_ids' => ['array', 'exists:tags,id'],
        ];
    }
}
