<?php

namespace App\Http\Controllers\PosBantuanHukum;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\PosBantuanHukum\PosBantuanHukum;
use App\Http\Resources\PosBantuanHukum\PosBantuanHukumResource;
use App\Mail\PosbantuanHukum\AutoRespond;

class PosBantuanHukumController extends Controller
{
        public function store(Request $request)
    {
        $validated = $request->validate([
            'namalengkap' => 'required',
            'nohp' => 'required',
            'email' => 'required',
            'deskribsi' => 'required',
            'suratgugatan' => 'required|file|mimes:pdf',
            'suratketerangantidakmampu' => 'required|file|mimes:pdf',
        ]);

        $currentUser = Auth::user();

        $suratgugatan = null;
        if ($request->hasFile('suratgugatan')) {
            $file = $request->file('suratgugatan');
            $suratgugatan = $file->getClientOriginalName();
            Storage::putFileAs('suratgugatan', $file, $suratgugatan);
        }

        $suratketerangantidakmampu = null;
        if ($request->hasFile('suratketerangantidakmampu')) {
            $file = $request->file('suratketerangantidakmampu');
            $suratketerangantidakmampu = $file->getClientOriginalName();
            Storage::putFileAs('suratketerangantidakmampu', $file, $suratketerangantidakmampu);
        }

        $data = $request->all();
        $data['suratketerangantidakmampu'] = $suratketerangantidakmampu;
        $data['suratgugatan'] = $suratgugatan;
        $data['author'] = $currentUser->id;

        $posbantuanhukum = PosBantuanHukum::create($data);
        
        // Mengirim email
        Mail::to($request->email)->send(new AutoRespond($currentUser, $request->namalengkap));

        return new PosBantuanHukumResource($posbantuanhukum->loadMissing('writer:id,username'));
    }
    
}
