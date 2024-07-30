<?php

namespace App\Http\Resources\Forum;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::guard('sanctum')->user();
        $userLiked = null;
        $userDisliked = null;

        if ($user) {
            $userLiked = $this->likes()->where('user_id', $user->id)->exists();
            $userDisliked = $this->dislikes()->where('user_id', $user->id)->exists();
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'image' => $this->image,
            'tags' => $this->tags,
            'author' => $this->author,
            'likes_count' => $this->likes()->count(),
            'dislikes_count' => $this->dislikes()->count(),
            'user_liked' => $userLiked,
            'user_disliked' => $userDisliked,
            'comment_total' => $this->whenLoaded('comments', function () {
                return $this->comments->count();
            }),
            'created_at' => date_format($this->created_at, "d-m-y H:i:s"),
            'writer' => $this->whenLoaded('writer', function () {
                return [
                    'id' => $this->writer->id,
                    'username' => $this->writer->username,
                    'profileimg' => $this->writer->profileimg,
                    'role' => $this->writer->role
                ];
            }),
            'comments' => $this->whenLoaded('comments', function () {
                return $this->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'comments_content' => $comment->comments_content,
                        'created_at' => $comment->created_at,
                        'commentator' => [
                            'id' => $comment->commentator->id,
                            'username' => $comment->commentator->username,
                            'profileimg' => $comment->commentator->profileimg,
                            'role' => $comment->commentator->role
                        ],
                        
                    ];
                });
            }),
        ];
    }
}