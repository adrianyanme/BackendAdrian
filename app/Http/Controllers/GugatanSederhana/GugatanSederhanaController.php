<?php

namespace App\Http\Controllers\GugatanSederhana;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log as log;
use App\Models\GugatanSederhana\GugatanSederhana;
use App\Http\Resources\GugatanSederhana\GugatanSederhanaResource;
use App\Http\Resources\GugatanSederhana\GugatanSederhanaResourceAll;
use App\Mail\GugatanSederhana\GugatanSederhana as GugatanSederhanaGugatanSederhana;

class GugatanSederhanaController extends Controller
{
    public function index()
    {
        $data = GugatanSederhana::all();
        return GugatanSederhanaResourceAll::collection($data);
    }
    public function show($id)
    {
        $data = GugatanSederhana::with('writer:id,username,firstname,lastname')->findOrFail($id);
        return new GugatanSederhanaResource($data->loadMissing('writer:id,username,firstname,lastname'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'nohp' => 'required',
            'nama_pengugat' => 'required',
            'nama_tergugat' => 'required',
            'penjelasan' => 'required',
            'tuntutan_pengugat' => 'required',
            'lampiran' => 'required|file|mimes:pdf', // Menambahkan validasi file
        ]);

        $lampiran = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $lampiran = $file->getClientOriginalName();
            Storage::putFileAs('public/gugatansederhana', $file, $lampiran);
        }
        $currentUser = Auth::user();

        $data = $request->all();
        $data['lampiran'] = $lampiran;
        $data['author'] = Auth::user()->id;

        $gugatan = GugatanSederhana::create($data);
        Mail::to($request->email)->send(new GugatanSederhanaGugatanSederhana($currentUser, $request->nama_pengugat, $request->nama_tergugat, $request->tuntutan_pengugat));

        return new GugatanSederhanaResource($gugatan->loadMissing('writer:id,username'));
    }

    private function RandomString($length = 10)
    {
        return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)), 0, $length);
    }
}
