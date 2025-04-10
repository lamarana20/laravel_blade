<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;
    protected $fillable = [
       
        'title',
        'body',
        'image',
        'user_id',
        
    ];
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function jaimes()
{
    return $this->hasMany(JaimePost::class);  // Ou le nom du modèle que vous utilisez pour gérer les "J'aime"
}

public function getJaimesCountAttribute()
{
    return $this->jaimes()->count();
}

}
