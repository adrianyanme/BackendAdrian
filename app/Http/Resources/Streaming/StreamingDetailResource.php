<?php

namespace App\Http\Resources\Streaming;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StreamingDetailResource extends JsonResource
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
            'thumbnail' => $this->thumbnail,
            'judul_streaming' => $this->judul_streaming,
            'youtube_link' => $this->youtube_link,
            'deskribsi' => $this->deskribsi,
            'status_stream' => $this->status_stream,
            'author' => $this->author,
            'created_at' => date_format($this->created_at, "d-m-y H:i:s"),
            'writer' => $this->whenLoaded('writer', function () {
                return [
                    'id' => $this->writer->id,
                    'username' => $this->writer->username,
                    'firstname' => $this->writer->firstname,
                    'lastname' => $this->writer->lastname,
                ];
            }),
            'livechat' => $this->whenLoaded('livechats', function (){
                return $this->livechats->map(function ($livechat){
                    return [
                        'id' => $livechat->id,
                        'chat' => $livechat->chat,
                        'writer' =>[
                            'id' => $livechat->writer->id,
                            'username' => $livechat->writer->username
                        ]

                    ];
                });
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
            'comment_total' => $this->whenLoaded('comments', function () {
                return $this->comments->count();
            }),
        ];
    }
}
