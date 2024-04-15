<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    // change le slug en bas a gauche de l'écran quand on survol les boutons de tags
    // Et aussi l'url quand on a cliqué dessus et qu'on arrive sur la page filtrée par tags
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // relation many to many tags - posts
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
