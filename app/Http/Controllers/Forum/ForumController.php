<?php

namespace App\Http\Controllers\Forum;

use App\Models\ForumLike;
use App\Models\Forum\Forum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Forum\ForumResource;
use App\Http\Resources\Forum\ForumDetailResource;

class ForumController extends Controller
{
    public function index()
    {
        $forums = Forum::all();
        return ForumResource::collection($forums->loadMissing(['writer:id,username,profileimg','comments']));
    }

    public function show($id)
    {
        $forum = Forum::findOrFail($id);
        return new ForumDetailResource($forum->loadMissing('writer:id,username,profileimg,role','comments:id,forums_id,user_id,comments_content,created_at'));
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required',
        'content' => 'required',
        'tags' => 'required',
        'files.*' => 'file|mimes:jpeg,png,jpg', // Menambahkan validasi file
    ]);

    $images = [];
    if ($request->hasFile('files')) {
        foreach ($request->file('files') as $file) {
            $filename = $this->RandomString();
            $extension = $file->getClientOriginalExtension(); // Menggunakan ekstensi asli file
            $image = $filename . '.' . $extension;

            Storage::putFileAs('public/forum', $file, $image);
            $images[] = $image;
        }
    }

    $request['images'] = json_encode($images);
    $request['author'] = Auth::user()->id;

    $forum = Forum::create($request->all());

    return new ForumResource($forum->loadMissing('writer:id,username'));
}

    private function RandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    public function destroy($id)
{
    $forum = Forum::findOrFail($id);
    $user = Auth::user();

    // Cek apakah pengguna adalah pemilik forum atau superadmin
    if ($forum->author != $user->id && $user->role != 'superadmin') {
        return response()->json(['message' => 'You do not have permission to delete this forum'], 403);
    }

    $forum->delete();
    return response()->json(['message' => 'Forum Successfully Deleted']);
}

    public function like($id)
    {
        $forum = Forum::findOrFail($id);
        $user = Auth::user();

        // Check if the user has already liked or disliked the forum
        $existingLike = ForumLike::where('forum_id', $forum->id)
                                 ->where('user_id', $user->id)
                                 ->first();

        if ($existingLike) {
            if ($existingLike->is_like) {
                return response()->json(['message' => 'You have already liked this forum'], 400);
            } else {
                // Update dislike to like
                $existingLike->update(['is_like' => true]);
                return response()->json(['message' => 'Forum liked successfully']);
            }
        } else {
            // Create a new like
            ForumLike::create([
                'forum_id' => $forum->id,
                'user_id' => $user->id,
                'is_like' => true,
            ]);
            return response()->json(['message' => 'Forum liked successfully']);
        }
    }

    public function dislike($id)
    {
        $forum = Forum::findOrFail($id);
        $user = Auth::user();

        // Check if the user has already liked or disliked the forum
        $existingLike = ForumLike::where('forum_id', $forum->id)
                                 ->where('user_id', $user->id)
                                 ->first();

        if ($existingLike) {
            if (!$existingLike->is_like) {
                return response()->json(['message' => 'You have already disliked this forum'], 400);
            } else {
                // Update like to dislike
                $existingLike->update(['is_like' => false]);
                return response()->json(['message' => 'Forum disliked successfully']);
            }
        } else {
            // Create a new dislike
            ForumLike::create([
                'forum_id' => $forum->id,
                'user_id' => $user->id,
                'is_like' => false,
            ]);
            return response()->json(['message' => 'Forum disliked successfully']);
        }
    }
}