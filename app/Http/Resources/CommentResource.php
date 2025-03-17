<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'post' => PostResource::make($this->whenLoaded('post')),
            'body' => $this->body,
            'likes_count' => Number::abbreviate($this->likes_count),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'can' => [
                'delete' =>  $request->user() ?  $request->user()->can('delete', $this->resource) : false,
                'update' =>  $request->user() ?  $request->user()->can('update', $this->resource) : false,
            ]
        ];
    }
}
