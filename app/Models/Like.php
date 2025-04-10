<?php

// app/Models/Like.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // Les attributs mass-assignables
    protected $fillable = ['user_id', 'comment_id'];

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec le commentaire
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
   
    }
}