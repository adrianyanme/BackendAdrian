<?php

namespace App\Models\PosBantuanHukum;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PosBantuanHukum extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'posbantuanhukum';

    protected $fillable = [
        'namalengkap','nohp','email','deskribsi','suratgugatan','suratketerangantidakmampu','author'
    ];

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

   /**
    * Get all of the comments for the Post
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
//    public function comments(): HasMany
//    {
//        return $this->hasMany(Comment::class, 'streaming_id', 'id');
//    }
}
