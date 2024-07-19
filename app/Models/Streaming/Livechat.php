<?php

namespace App\Models\Streaming;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livechat extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'livechat';
    protected $fillable = [
        'streaming_id', 'user_id', 'chat'
    ];

    /**
     * Get the commentator that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
