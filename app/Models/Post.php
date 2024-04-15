<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    // $fillable indique les champs qui doivent subir le mass assignment
    // $guarded indique ceux qui doivent être protégés du mass assignment
    protected $guarded = ['id', 'created_at', 'updated_at'];

    // regroupe les queries pour optimiser la conso de données du site (voir foreachs sur post.blade.php)
    protected $with = [
        'category', 
        'tags'
    ];

    // change le slug en bas a gauche de l'écran quand on survol les boutons "lire l'article"
    // Et aussi l'url quand on a cliqué dessus et qu'on arrive sur la page de l'article
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeFilters(Builder $query, array $filters): void 
    {
        // si il y a une clé search dans le tableau filters
        if (isset($filters['search'])) {
            // query similaire a celle dans PostController.php
            // si clé search présente dans le tableau, sera utilisée pour une recherche
            $query->where(fn (Builder $query) => $query
                ->where('title', 'LIKE', '%' . $filters['search'] . '%')
                ->orWhere('content', 'LIKE', '%' . $filters['search'] . '%')
            );
        }

        if (isset($filters['category'])) {
            $query->where( // clause where pour comparer colonne<>valeur (opérateur 'égal' par défaut)
                // ?? est null coalescing operator, retourne le 1er opérant s'il existe et qu'il ne vaut pas null, sinon retourne le 2e
                'category_id', $filters['category']->id ?? $filters['category']
            );
        }

        if (isset($filters['tag'])) {
            $query->whereRelation(
                'tags', 'tags.id', $filters['tag']->id ?? $filters['tag']
            );
        }
    }

    // relation post - categ, un post appartient a une categ
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // relation many to many tags - posts
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
