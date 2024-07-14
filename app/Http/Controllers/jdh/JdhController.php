<?php

namespace App\Http\Controllers\jdh;

use App\Models\jdh\jdh;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Resources\jdh\JdhResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\jdh\JdhResourceAll;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JdhController extends Controller
{
    public function index()
    {
        $show = jdh::all();
        return JdhResourceAll::collection($show);
    }

    public function show($id)
    {
        try {
            $jdh = Jdh::findOrFail($id);
            return new JdhResource($jdh);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundHttpException('Data not found.');
        } catch (\Exception $e) {
            throw new \Exception('Failed to retrieve data.');
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required|max:99999',
            'nomor' => 'required',
            'tahun' => 'required',
            'kategoridokumen' => 'required',
            'jenis' => 'required',
            'tanggalditetapkan' => 'required',
            'tanggaldiundangkan' => 'required',
            'status' => 'required',
            'sumber' => 'required',
            'keterangan' => 'required',
            'lampiran' => 'required|file|mimes:pdf,png,jpg,mp4'
        ]);

        $lampiran = null;
        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $lampiran = $file->getClientOriginalName();
            Storage::putFileAs('public/jdh', $file, $lampiran);
        }

        $data = $request->all();
        $data['lampiran'] = $lampiran;

        $pengaduan = jdh::create($data);

        return response()->json($pengaduan, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'sometimes|required',
            'deskripsi' => 'sometimes|required|max:99999',
            'nomor' => 'sometimes|required',
            'tahun' => 'sometimes|required',
            'kategoridokumen' => 'sometimes|required',
            'jenis' => 'sometimes|required',
            'tanggalditetapkan' => 'sometimes|required',
            'tanggaldiundangkan' => 'sometimes|required',
            'status' => 'sometimes|required',
            'sumber' => 'sometimes|required',
            'keterangan' => 'sometimes|required',
            'lampiran' => 'sometimes|required|file|mimes:pdf,png,jpg,mp4'
        ]);

        $jdh = jdh::findOrFail($id);

        $data = $request->only('judul', 'deskripsi', 'nomor', 'tahun', 'kategoridokumen', 'jenis', 'tanggalditetapkan', 'tanggaldiundangkan', 'status', 'sumber', 'keterangan');

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $lampiran = $file->getClientOriginalName();
            Storage::putFileAs('public/jdh', $file, $lampiran);
            $data['lampiran'] = $lampiran;
        }

        $jdh->update($data);

        return response()->json($jdh, 201);
    }
}
