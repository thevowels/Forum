<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class LikeController extends Controller
{

    use AuthorizesRequests;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $type, int $id)
    {

        $modelName = Relation::getMorphedModel($type);
        if($modelName ===  null) {
            throw new ModelNotFoundException();
        }

        $likeable = $modelName::findOrFail($id);

//        Gate::authorize('create',[Like::class, $likeable]);
        $this->authorize('create', [Like::class, $likeable]);

        $likeable->likes()->create([
            'user_id' => $request->user()->id,
        ]);

        $likeable->increment('likes_count');
        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $type, int $id)
    {
        //
        $modelName = Relation::getMorphedModel($type);
        if($modelName ===  null) {
            throw new ModelNotFoundException();
        }

        $likeable = $modelName::findOrFail($id);

        $this->authorize('delete', [Like::class, $likeable]);

        $likeable->likes()->whereBelongsTo($request->user())->delete();


        $likeable->decrement('likes_count');

        return back();
    }
}
