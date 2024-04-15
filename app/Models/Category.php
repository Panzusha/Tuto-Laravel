<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    // change le slug en bas a gauche de l'écran quand on survol les boutons de categories
    // Et aussi l'url quand on a cliqué dessus et qu'on arrive sur la page filtrée par categories
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // relation categ - post , une categ a plusieurs posts
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
