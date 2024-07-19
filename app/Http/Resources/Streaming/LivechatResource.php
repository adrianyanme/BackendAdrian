<?php

namespace App\Http\Resources\Streaming;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LivechatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'chat' => $this->comments_content,
            'user_id' => $this->user_id,
            'writer' => $this->whenLoaded('writer'),
            'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
        ];
    }
}
