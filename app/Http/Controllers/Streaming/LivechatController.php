<?php

namespace App\Http\Controllers\Streaming;

use Illuminate\Http\Request;
use App\Models\Streaming\Streaming;
use App\Http\Controllers\Controller;
use App\Http\Resources\Streaming\LivechatResource;
use App\Http\Resources\Streaming\StreamingResource;
use App\Models\Streaming\Livechat;

class LivechatController extends Controller
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
            'chat' => 'required',
        ]);

        $request['user_id'] = auth()->user()->id;

        $comment =Livechat::create($request->all());

      
        return new LivechatResource($comment->loadMissing(['writer:id,username']));
    }
}
