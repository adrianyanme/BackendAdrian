<?php

namespace App\Models\Persalinan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Persalinan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'persalinan';

    protected $fillable = [
        'email','jenissalinan','putusanyangdiminta','namapemohon','nohp','statuspemohon','noperkara','author'
    ];
}
