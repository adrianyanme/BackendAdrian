<?php

namespace App\Models\jdh;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class jdh extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'jdh';

    protected $fillable = [
        'judul','deskripsi','nomor','tahun','kategoridokumen','jenis','tanggalditetapkan','tanggaldiundangkan','status','sumber','keterangan','lampiran'
    ];
}
