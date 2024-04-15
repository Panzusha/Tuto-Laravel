<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $with = ['user'];

    // activation mass assignment
    // protected $fillable = ['content', 'post_id', 'user_id'];

    // inverse de $fillable, donc activation du mass assignment par omission des colonnes de $fillable
    // les colonnes ci dessous seront protégées
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }
}
