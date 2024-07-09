<?php

namespace App\Models\LayananPengaduan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayananPengaduan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'layanan_pengaduan';

    protected $fillable = [
        'judullaporan','isilaporan','tanggalkejadian','instansiterlapor','lampiran'
    ];
}
