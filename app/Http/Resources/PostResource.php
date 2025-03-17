<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'user' => UserResource::make($this->user),
//            'topic' => $this->whenLoaded('topic', fn () => TopicResource::make($this->topic)),
            'topic' => TopicResource::make($this->topic),
            'title' => $this->title,
            'body' => $this->body,
            'updated_at'=> $this->updated_at,
            'created_at' => $this->created_at,
            'routes'=> [
                'show' => $this->showRoute(),
            ]
        ];
    }
}
