<?php

namespace App\Http\Resources\jdh;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JdhResource extends JsonResource
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
            'nomor' => $this->nomor,
            'tahun' => $this->tahun,
            'kategoridokumen' => $this->kategoridokumen,
            'jenis' => $this->jenis,
            'tanggalditetapkan' => $this->tanggalditetapkan,
            'tanggaldiundangkan' => $this->tanggaldiundangkan,
            'status' => $this->status,
            'sumber' => $this->sumber,
            'keterangan' => $this->keterangan,
            'lampiran' => $this->lampiran,
            'created_at' => date_format($this->created_at, "d-m-y H:i:s"),
        ];
    }
}
