<?php

namespace App\Models\Forum;

use App\Models\User;
use App\Models\ForumLike;
use App\Models\Forum\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Forum extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'forums';

    protected $fillable = [
        'title','content','image','tags','author','images'
    ];
    protected $casts = [
        'images' => 'array',
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
        return $this->hasMany(Comment::class, 'forums_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(ForumLike::class)->where('is_like', true);
    }

    public function dislikes()
    {
        return $this->hasMany(ForumLike::class)->where('is_like', false);
    }
}