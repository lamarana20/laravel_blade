<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'user_id', 'post_id'];

    // Relation avec l'utilisateur (auteur du commentaire)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function likes()
{
    return $this->hasMany(Like::class);
}

    
}
