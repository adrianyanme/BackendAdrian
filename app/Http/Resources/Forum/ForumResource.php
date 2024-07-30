<?php

namespace App\Http\Resources\Forum;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'images' => $this->images,
            'tags' => $this->tags,
            'author' => $this->author,
            'likes_count' => $this->likes()->count(),
            'dislikes_count' => $this->dislikes()->count(),
            'created_at' => date_format($this->created_at, "d-m-y H:i:s"),
            'updated_at' => $this->updated_at,
            'writer' => $this->whenLoaded('writer', function () {
                return [
                    'id' => $this->writer->id,
                    'username' => $this->writer->username,
                    'profileimg' => $this->writer->profileimg
                ];
            }),
            'comment_total' => $this->whenLoaded('comments', function () {
                return $this->comments->count();
            }),
        ];
    }
}