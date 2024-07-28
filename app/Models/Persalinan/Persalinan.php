<?php

namespace App\Models\Persalinan;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persalinan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'persalinan';

    protected $fillable = [
        'email','jenissalinan','putusanyangdiminta','namapemohon','nohp','statuspemohon','noperkara','author','namaparapihak','ktppemohon','kkpemohon','relaaspemberitahuanputusan','catatanpemohon','status'
    ];

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
