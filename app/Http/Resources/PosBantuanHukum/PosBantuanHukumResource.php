<?php

namespace App\Http\Resources\PosBantuanHukum;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PosBantuanHukumResource extends JsonResource
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
            'namalengkap' => $this->namalengkap,
            'nohp' => $this->nohp,
            'email' => $this->email,
            'deskribsi' => $this->deskribsi,
            'suratgugatan' => $this->suratgugatan,
            'suratketerangantidakmampu' => $this->suratketerangantidakmampu,
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
        ];
        
        // return parent::toArray($request);
    }
}
