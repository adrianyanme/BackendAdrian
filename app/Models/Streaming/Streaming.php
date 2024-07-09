<?php

namespace App\Models\Streaming;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Streaming extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'streaming';

    protected $fillable = [
        'thumbnail','judul_streaming','youtube_link','deskribsi','status_stream','author'
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
   public function comments(): HasMany
   {
       return $this->hasMany(Comment::class, 'streaming_id', 'id');
   }
}
