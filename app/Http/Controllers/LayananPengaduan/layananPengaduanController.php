<?php

namespace App\Http\Controllers\LayananPengaduan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LayananPengaduan\LayananPengaduan;
use Illuminate\Support\Facades\Storage;
use App\Models\PosBantuanHukum\PosBantuanHukum;

class layananPengaduanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judullaporan' => 'required',
            'isilaporan' => 'required',
            'tanggalkejadian' => 'required|date_format:Y-m-d H:i:s',
            'instansiterlapor' => 'required',
            'lampiran' => 'required|file|mimes:pdf,png,jpg,mp4'
        ]);

        $suratgugatan = null;
        if ($request->hasFile('suratgugatan')) {
            $file = $request->file('suratgugatan');
            $suratgugatan = $file->getClientOriginalName();
            Storage::putFileAs('suratgugatan', $file, $suratgugatan);
        }

        $data = $request->all();
        $data['Layanan Pengaduan'] = $suratgugatan;

        $pengaduan = LayananPengaduan::create($validated);

        return response()->json($pengaduan, 201);
    }
}
