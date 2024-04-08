<?php

namespace App\Http\Controllers;

use App\Models\CommentPost;
use App\Models\Post;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentPostController extends Controller
{
    public function index($postId)
    {
        $post = Post::with('comments')->findOrFail($postId);
        return view('dashboard', compact('post'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required'
        ]);

        $comment = new CommentPost();
        $comment->user_id = auth()->id();
        $comment->post_id = $request->post_id;
        $comment->text = $request->text;
        $comment->save();

        return back();
    }

    public function destroy(CommentPost $comment)
    {
        $comment->delete();

        return back();
    }
}
