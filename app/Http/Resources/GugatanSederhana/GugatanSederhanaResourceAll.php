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
            'email' => $this->email,
            'nohp' => $this->nohp,
            'nama_pengugat' => $this->nama_pengugat,
            'nama_tergugat' => $this->nama_tergugat,
            'penjelasan' => $this->penjelasan,
            'tuntutan_pengugat' => $this->tuntutan_pengugat,
            'lampiran' => $this->lampiran,
            'author' => $this->author,
            'created_at' => date_format($this->created_at, "d-m-y H:i:s"),
            'writer' => $this->whenLoaded('writer', function () {
                return [
                    'id' => $this->writer->id,
                    'username' => $this->writer->username,
                ];
            }),
        ];
    }
}
