<?php

namespace App\Models\GugatanSederhana;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GugatanSederhana extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'gugatansederhanalangsung';

    protected $fillable = [
        'email','nohp','nama_pengugat','nama_tergugat','penjelasan','tuntutan_pengugat','lampiran','author'
    ];

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

}
