<?php

namespace App\Http\Resources\Forum;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForumDetailResource extends JsonResource
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
            'tags' => $this->tags,
            'author' => $this->author,
            'comment_total' => $this->whenLoaded('comments', function () {
                return $this->comments->count();
            }),
            'created_at' => date_format($this->created_at, "d-m-y H:i:s"),
            'writer' => $this->whenLoaded('writer', function () {
                return [
                    'id' => $this->writer->id,
                    'username' => $this->writer->username,
                ];
            }),
            'comments' => $this->whenLoaded('comments', function () {
                return $this->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'comments_content' => $comment->comments_content,
                        'commentator' => [
                            'id' => $comment->commentator->id,
                            'username' => $comment->commentator->username,
                        ],
                    ];
                });
            }),
        ];
    }
}
