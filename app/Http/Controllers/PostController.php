<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia('Posts/Index', [
            'posts'=> PostResource::collection(Post::with('user:id,name')->latest()->latest('id')->paginate()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'title' => ['required','string', 'min:5','max:120'],
            'body' => ['required', 'string', 'min:10', 'max:1500'],
        ]);
        $post = Post::make($data);
        $post->user()->associate($request->user())
            ->save();

        return redirect()->route('posts.show', $post );

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
        return Inertia::render('Posts/Show', [
            'post' => fn() => PostResource::make($post),
            'comments' => fn() =>  CommentResource::collection($post->comments()->with('user')->orderByDesc('created_at')->paginate(3)),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
