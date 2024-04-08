<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentPost extends Model
{
    use HasFactory;

    public function Posts() {
        return $this->belongsTo(Post::class);
    }

    public function User() {
        return $this->belongsTo(User::class);
    }
}
