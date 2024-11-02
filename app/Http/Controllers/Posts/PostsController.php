<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->with(['user', 'likes'])->paginate(10);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);

        $request->user()->posts()->create([
            'body' => $request->body,
        ]);

        return back();
    }

    public function destroy(Post $post)
    {
        if (!Gate::allows('delete', $post)) {
            abort(403);
        }
        
        $post->delete();

        return back();
    }
}
