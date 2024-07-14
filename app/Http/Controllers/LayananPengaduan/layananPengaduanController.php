<?php

namespace App\Http\Controllers\LayananPengaduan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LayananPengaduan\layananPengaduanResource;
use App\Models\LayananPengaduan\LayananPengaduan;
use Illuminate\Support\Facades\Storage;

class LayananPengaduanController extends Controller
{
        public function index()
    {
        $show = LayananPengaduan::all();
        return layananPengaduanResource::collection($show);
    }

        public function store(Request $request)
    {
        $validated = $request->validate([
            'judullaporan' => 'required',
            'isilaporan' => 'required',
            'tanggalkejadian' => 'required|date_format:Y-m-d',
            'instansiterlapor' => 'required',
            'lampiran' => 'required|file|mimes:pdf,png,jpg,mp4'
        ]);

        $lampiran = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $lampiran = $file->getClientOriginalName();
            Storage::putFileAs('public/lampiran', $file, $lampiran);
        }

        $data = $request->all();
        $data['lampiran'] = $lampiran;
        $pengaduan = LayananPengaduan::create($data);


        return response()->json($pengaduan, 201);
    }
}
