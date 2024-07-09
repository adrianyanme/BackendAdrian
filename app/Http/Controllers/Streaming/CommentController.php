<?php

namespace App\Http\Controllers\Streaming;

use Illuminate\Http\Request;
use App\Models\Streaming\Comment;
use App\Http\Controllers\Controller;
use App\Http\Resources\Streaming\CommentResource;
use App\Http\Resources\Streaming\StreamingResource;
use App\Models\Streaming\Streaming;

class CommentController extends Controller
{
    public function index ()
    {
        $streaming = Streaming::all();
        return StreamingResource::collection($streaming->loadMissing(['writer:id,username']));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'streaming_id' => 'required|exists:streaming,id',
            'comments_content' => 'required',
        ]);

        $request['user_id'] = auth()->user()->id;

        $comment =Comment::create($request->all());

      
        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'comments_content' => 'required',
        ]);
        $comment = Comment::findOrFail($id);
        $comment->update($request->only('comments_content'));
        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return new CommentResource($comment->loadMissing('commentator:id,username'));
    }
}
