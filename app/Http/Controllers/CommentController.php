<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use AuthorizesRequests;


    /**
     * Display a listing of the resource.
     */

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
        return redirect($post->showRoute())->banner('Added a new comment');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
        $validated = $request->validate(['body'=>['required','string','max:255']]);
        $this->authorize('update', $comment);
        $comment->update($validated);

        return redirect()->route('posts.show', ['post' => $comment->post, 'page'=> $request->query('page')])
            ->with(
                'flash', [
                    'bannerStyle' => 'success',
                    'banner' => 'comment Updated Successfully',
                ]
            );


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        //
        $this->authorize('delete', $comment);

        $comment->delete();
        return redirect()->route('posts.show', ['post'=> $comment->post_id,'slug' => 'adsf', 'page'=> $request->get('page') ])
            ->banner('comment Deleted!');
    }
}
