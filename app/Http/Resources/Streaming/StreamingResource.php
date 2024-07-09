<?php

namespace App\Http\Resources\Streaming;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StreamingResource extends JsonResource
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
        ];
        
        // return parent::toArray($request);
    }
}
