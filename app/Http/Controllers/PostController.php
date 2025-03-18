<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TopicResource;
use App\Models\Post;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

use App\Models\Topic;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;


    public function index(Request $request, Topic $topic=null)
    {
        if($request->query('query')){
            $posts = Post::search($request->query('query'))
                ->when($topic, fn (\Laravel\Scout\Builder $query) => $query->where('topic_id', $topic->id));

        }else{
                    $posts = Post::with(['user','topic'])
            ->when($topic, fn ( $query) => $query->whereBelongsTo($topic))
            ->latest('id');

        }




        $this->authorize('viewAny', Post::class);
        return Inertia::render('Posts/Index', [
            'posts'=> PostResource::collection($posts->paginate()->withQueryString()),
            'selectedTopic' => fn () => $topic ? TopicResource::make($topic) : null,
            'topics' => fn () =>  TopicResource::collection(Topic::all()),
            'query' => $request->query('query'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('create', Post::class);
        return Inertia::render('Posts/Create',[
            'topics' => fn () =>  TopicResource::collection(Topic::all()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'title' => ['required','string', 'min:5','max:120'],
            'topic_id' => ['required', 'exists:topics,id'],
            'body' => ['required', 'string', 'min:100', 'max:1500'],
        ]);
        $post = Post::create([
            ...$data,
            "user_id" => auth()->id(),
        ]);

        return redirect($post->showRoute());

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post, Request $request)
    {
        //

        if( !Str::contains($post->showRoute(), $request->path())){
            return redirect($post->showRoute($request->query()), status: 301);
        }
        $post->load('user', 'topic');

        return Inertia::render('Posts/Show', [
            'post' => fn() => PostResource::make($post)->withLikePermission(),
            'comments' => fn() =>  CommentResource::collection($post->comments()->orderByDesc('id')->with('user')->paginate(3)),
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
