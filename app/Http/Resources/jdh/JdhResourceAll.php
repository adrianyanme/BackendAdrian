<?php

namespace App\Http\Resources\jdh;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JdhResourceAll extends JsonResource
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
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
        ];
    }
}
