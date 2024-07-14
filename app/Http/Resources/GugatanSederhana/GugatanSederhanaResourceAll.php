<?php

namespace App\Http\Resources\GugatanSederhana;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GugatanSederhanaResourceAll extends JsonResource
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
            'nama_pengugat' => $this->nama_pengugat,
            'nama_tergugat' => $this->nama_tergugat,
            'penjelasan' => $this->penjelasan,
        ];
    }
}
