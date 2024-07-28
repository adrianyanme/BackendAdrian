<?php

namespace App\Http\Resources\Persalinan;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersalinanResource extends JsonResource
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
            'jenissalinan' => $this->jenissalinan,
            'putusanyangdiminta' => $this->putusanyangdiminta,
            'namapemohon' => $this->namapemohon,
            'nohp' => $this->nohp,
            'statuspemohon' => $this->statuspemohon,
            'noperkara' => $this->noperkara,
            'author' => $this->author,
            // 'comment_total' => $this->whenLoaded('comments', function () {
            //     return $this->comments->count();
            // }),
            'created_at' => date_format($this->created_at, "d-m-y H:i:s"),
            'writer' => $this->whenLoaded('writer', function () {
                return [
                    'id' => $this->writer->id,
                    'username' => $this->writer->username,
                ];
            }),
            'namaparapihak' => $this->namaparapihak,
            'ktppemohon' => $this->ktppemohon,
            'kkpemohon' => $this->kkpemohon,
            'relaaspemberitahuanputusan' => $this->relaaspemberitahuanputusan,
            'catatanpemohon' => $this->catatanpemohon,
            'status' => $this->status,
        ];
    }
}
