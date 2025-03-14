<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('posts.comments', CommentController::class)->shallow()->only(['store', 'update', 'destroy']);
    Route::resource('posts', PostController::class)->shallow()->only(['store','create']);
});

Route::get('test',function(){
    return  [
        UserResource::make(User::find(1)),
        PostResource::make(Post::find(1)),
        CommentResource::make(Comment::find(1)),
    ];
});

Route::resource('posts', PostController::class)->only(['index', 'show']);




