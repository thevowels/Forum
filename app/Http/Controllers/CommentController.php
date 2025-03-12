<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;
    public function index()
    {
        //
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
    public function store(Request $request, Post $post)
    {
        //
        $validated = $request->validate([
            'body' => ['required','string','max:255'],
        ]);
        Comment::make($validated)
            ->user()->associate($request->user())
            ->post()->associate($post)
            ->save();
        return redirect()->route('posts.show', $post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
        $validated = $request->validate(['body'=>['required','string','max:255']]);

        $comment->update($validated);

        return redirect()->route('posts.show', $comment->post);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        //
        $this->authorize('delete', $comment);

        $comment->delete();
        return redirect()->route('posts.show', ['post'=> $comment->post_id, 'page'=> $request->get('page') ]);
    }
}
