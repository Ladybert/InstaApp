<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'posts' => Post::withCount('likes')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('crud.post',[
            'posts' => Post::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
            'text' => 'required'
        ]);

        $user = Auth::user();
        $image = null;
        
        if($request->hasFile('image')){
            $image = $request->file('image')->store('postImg');
        }

        // dd($request->all());
        $post = $user->posts()->create([
            'image' => $image,
            'text' => $request->text,
        ]);

        return redirect()->route('post.index')->with('success', 'New post has been created!');
    }

    public function edit($id)
    {
        $edit = Post::findOrFail($id);
        return view('crud.edit', compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'required',
            'text' => 'required'
        ]);

        $user = Auth::user();
        $image = null;

        $post = Post::findOrFail($id);
        
        if($request->hasFile('image')){
            $image = $request->file('image')->store('postImg');

             //delete old image
            Storage::delete('postImg'.$post->image);
        }

        $post->image = $image;
        $post->text = $request->text;

        $post->save();

        return redirect()->route('post.index')->with('success', 'Post has been edited!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('post.index');
    }
}
