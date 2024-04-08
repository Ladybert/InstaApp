<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikePost extends Model
{
    use HasFactory;

    public function userLikes() {
        return $this->belongsTo(User::class);
    }

    public function likePost() {
        return $this->belongsTo(Post::class);
    }
}
