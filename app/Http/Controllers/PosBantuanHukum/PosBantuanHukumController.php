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
        try {
            // Validate incoming request
            $validated = $request->validate([
                'namalengkap' => 'required',
                'nohp' => 'required',
                'email' => 'required|email',
                'deskribsi' => 'required',
                'suratgugatan' => 'required|file|mimes:pdf',
                'suratketerangantidakmampu' => 'required|file|mimes:pdf',
            ]);

            // Get current user
            $currentUser = Auth::user();

            // Handle file uploads
            $suratgugatan = null;
            if ($request->hasFile('suratgugatan')) {
                $file = $request->file('suratgugatan');
                if ($file->isValid()) {
                    $suratgugatan = $file->getClientOriginalName();
                    Storage::putFileAs('public/suratgugatan', $file, $suratgugatan);
                } else {
                    throw new \Exception('Invalid file uploaded for suratgugatan.');
                }
            }

            $suratketerangantidakmampu = null;
            if ($request->hasFile('suratketerangantidakmampu')) {
                $file = $request->file('suratketerangantidakmampu');
                if ($file->isValid()) {
                    $suratketerangantidakmampu = $file->getClientOriginalName();
                    Storage::putFileAs('public/suratketerangantidakmampu', $file, $suratketerangantidakmampu);
                } else {
                    throw new \Exception('Invalid file uploaded for suratketerangantidakmampu.');
                }
            }

            // Store data in database
            $data = $request->all();
            $data['suratketerangantidakmampu'] = $suratketerangantidakmampu;
            $data['suratgugatan'] = $suratgugatan;
            $data['author'] = $currentUser->id;

            $posbantuanhukum = PosBantuanHukum::create($data);

            // Send email
            Mail::to($request->email)->send(new AutoRespond($currentUser, $request->namalengkap));

            // Return response
            return new PosBantuanHukumResource($posbantuanhukum->loadMissing('writer:id,username'));

        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in PosBantuanHukumController@store: ' . $e->getMessage());

            // Return error response
            return response()->json(['message' => 'Failed to process request. Please try again later.'], 500);
        }
    }
}
