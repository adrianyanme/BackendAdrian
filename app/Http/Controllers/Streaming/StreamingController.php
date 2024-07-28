<?php

namespace App\Http\Controllers\Streaming;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Streaming\StreamingDetailResource;
use App\Http\Resources\Streaming\StreamingResource;
use App\Models\Streaming\Comment;
use App\Models\Streaming\Streaming;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StreamingController extends Controller
{
    public function index ()
    {
        $streaming = Streaming::all();
        return StreamingResource::collection($streaming->loadMissing(['writer:id,username','comments']));
    }
    public function show($id)
    {
        $comment = Streaming::with('writer:id,username,firstname,lastname')->findOrFail($id);
        return new StreamingDetailResource($comment->loadMissing(['writer:id,username,firstname,lastname', 'comments:id,streaming_id,user_id,comments_content','livechats:id,streaming_id,user_id,chat']));
    }


    public function store(Request $request)
{
    $user = Auth::user();

    // Cek apakah pengguna adalah superadmin
    if ($user->role != 'superadmin') {
        return response()->json(['message' => 'You do not have permission to create a streaming'], 403);
    }

    $validated = $request->validate([
        'judul_streaming' => 'required',
        'youtube_link' => 'required',
        'deskribsi' => 'required',
        'status_stream' => 'required',
        'file' => 'required|file|mimes:jpeg,png,jpg,gif', // Menambahkan validasi file
    ]);

    $image = null;
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = $this->RandomString();
        $extension = $file->getClientOriginalExtension(); // Menggunakan ekstensi asli file
        $image = $filename . '.' . $extension;

        Storage::putFileAs('public/thumbnails', $file, $image);
    }

    $request['thumbnail'] = $image;
    $request['author'] = $user->id;

    $streaming = Streaming::create($request->all());

    return new StreamingResource($streaming->loadMissing('writer:id,username'));
}

    private function RandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    public function update(Request $request, $id)
    {
    // Validasi input request. Hanya validasi kolom yang diperlukan.
    $validated = $request->validate([
        'judul_streaming' => 'sometimes|required',
        'youtube_link' => 'sometimes|required',
        'deskribsi' => 'sometimes|required',
        'status_stream' => 'sometimes|required',
        'file' => 'sometimes|required|file|mimes:jpeg,png,jpg,gif',
    ]);

    // Temukan post berdasarkan ID atau gagal jika tidak ditemukan.
    $streaming = Streaming::findOrFail($id);

    // Ambil hanya kolom yang ada dalam request dan perbarui model.
    $streaming->update($request->only('judul_streaming','youtube_link','deskribsi','status_stream','file'));

    return new StreamingResource($streaming->loadMissing('writer:id,username'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status_stream' => 'required',
        ]);

        $streaming = Streaming::findOrFail($id);
        $user = Auth::user();

        // Cek apakah pengguna adalah superadmin
        if ($user->role != 'superadmin') {
            return response()->json(['message' => 'You do not have permission to update the status'], 403);
        }

        $streaming->status_stream = $request->status_stream;
        $streaming->save();

        return new StreamingResource($streaming->loadMissing('writer:id,username'));
    }

    public function destroy($id)
    {
        $streaming = Streaming::findOrFail($id);
        $user = Auth::user();

        // Cek apakah pengguna adalah superadmin
        if ($user->role != 'superadmin') {
            return response()->json(['message' => 'You do not have permission to delete this streaming'], 403);
        }

        $streaming->delete();
        return response()->json(['message' => 'Streaming Successfully Deleted']);
    }

}