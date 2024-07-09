<?php

namespace App\Http\Resources\LayananPengaduan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class layananPengaduanResource extends JsonResource
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
            'judullaporan' => $this->judullaporan,
            'isilaporan' => $this->isilaporan,
            'tanggalkejadian' => $this->tanggalkejadian,
            'instansiterlapor' => $this->instansiterlapor,
            'lampiran' => $this->lampiran,
            // 'comment_total' => $this->whenLoaded('comments', function () {
            //     return $this->comments->count();
            // }),
            'created_at' => date_format($this->created_at, "d-m-y H:i:s"),
            // 'writer' => $this->whenLoaded('writer', function () {
            //     return [
            //         'id' => $this->writer->id,
            //         'username' => $this->writer->username,
            //     ];
            // }),
        ];
    }
}
