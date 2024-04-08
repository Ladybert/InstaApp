<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\LikePost;
use Illuminate\Http\Request;

class LikePostController extends Controller
{
    public function post($id)
    {
        $user = auth()->user();
        $post = Post::findOrFail($id);

        // Check if user has already liked the post
        $like = $post->likes()->where('user_id', $user->id)->first();

        if ($like) {
            // Unlike post
            $like->delete();
        } else {
            // Like post
            $post->likes()->create([
                'user_id' => $user->id,
                'post_id' => $post->id
            ]);
        }

        return redirect()->route('post.index');
    }
}
