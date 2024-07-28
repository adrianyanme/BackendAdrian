<?php

namespace App\Http\Controllers\Persalinan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\Persalinan\Persalinan;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Persalinan\PersalinanResource;
use App\Mail\Persalinan\Persalinan as PersalinanPersalinan;

class PersalinanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'jenissalinan' => 'required',
            'putusanyangdiminta' => 'required',
            'namapemohon' => 'required',
            'nohp' => 'required',
            'statuspemohon' => 'required',
            'noperkara' => 'required',
            'namaparapihak' => 'required',
            'ktppemohon' => 'required|file|mimes:pdf,png,jpg,jpeg',
            'kkpemohon' => 'required|file|mimes:pdf,png,jpg,jpeg',
            'relaaspemberitahuanputusan' => 'required|file|mimes:pdf,png,jpg,jpeg',
            'catatanpemohon' => 'required',
        ]);

        $ktppemohon = null;
        if ($request->hasFile('ktppemohon')) {
            $file = $request->file('ktppemohon');
            if ($file->isValid()) {
                $path = $file->store('public/ktppemohon');
                $ktppemohon = Storage::url($path);
            } else {
                throw new \Exception('Invalid file uploaded for ktppemohon.');
            }
        }

        $kkpemohon = null;
        if ($request->hasFile('kkpemohon')) {
            $file = $request->file('kkpemohon');
            if ($file->isValid()) {
                $path = $file->store('public/kkpemohon');
                $kkpemohon = Storage::url($path);
            } else {
                throw new \Exception('Invalid file uploaded for kkpemohon.');
            }
        }

        $relaaspemberitahuanputusan = null;
        if ($request->hasFile('relaaspemberitahuanputusan')) {
            $file = $request->file('relaaspemberitahuanputusan');
            if ($file->isValid()) {
                $path = $file->store('public/relaaspemberitahuanputusan');
                $relaaspemberitahuanputusan = Storage::url($path);
            } else {
                throw new \Exception('Invalid file uploaded for relaaspemberitahuanputusan.');
            }
        }

        $currentUser = Auth::user();
        $data = $request->all();
        $data['author'] = Auth::user()->id;
        $data['status'] = 'pending';
        $data['ktppemohon'] = $ktppemohon;
        $data['kkpemohon'] = $kkpemohon;
        $data['relaaspemberitahuanputusan'] = $relaaspemberitahuanputusan;

        $persalinan = Persalinan::create($data);

        Mail::to($request->email)->send(new PersalinanPersalinan($currentUser, $request->namapemohon, $request->noperkara));

        return new PersalinanResource($persalinan->loadMissing(['writer:id,username']));
    }


    public function index()
    {
        $user = Auth::user();

        // Cek apakah pengguna adalah superadmin
        if ($user->role != 'superadmin') {
            return response()->json(['message' => 'You do not have permission to view this data'], 403);
        }

        $persalinan = Persalinan::all();
        return PersalinanResource::collection($persalinan);
    }
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'email' => 'required',
    //         'jenissalinan' => 'required',
    //         'putusanyangdiminta' => 'required',
    //         'namapemohon' => 'required',
    //         'nohp' => 'required',
    //         'statuspemohon' => 'required',
    //         'noperkara' => 'required',
    //         'namaparapihak' => 'required',
    //         'ktppemohon' => 'required|file|mimes:pdf,png,jpg,jpeg',
    //         'kkpemohon' => 'required|file|mimes:pdf,png,jpg,jpeg',
    //         'relaaspemberitahuanputusan' => 'required|file|mimes:pdf,png,jpg,jpeg',
    //         'catatanpemohon' => 'required',
    //     ]);

    //     $ktppemohon = null;
    //     if ($request->hasFile('ktppemohon')) {
    //         $file = $request->file('ktppemohon');
    //         if ($file->isValid()) {
    //             $path = $file->store('public/ktppemohon');
    //             $ktppemohon = Storage::url($path);
    //         } else {
    //             throw new \Exception('Invalid file uploaded for ktppemohon.');
    //         }
    //     }

    //     $kkpemohon = null;
    //     if ($request->hasFile('kkpemohon')) {
    //         $file = $request->file('kkpemohon');
    //         if ($file->isValid()) {
    //             $path = $file->store('public/kkpemohon');
    //             $kkpemohon = Storage::url($path);
    //         } else {
    //             throw new \Exception('Invalid file uploaded for kkpemohon.');
    //         }
    //     }

    //     $relaaspemberitahuanputusan = null;
    //     if ($request->hasFile('relaaspemberitahuanputusan')) {
    //         $file = $request->file('relaaspemberitahuanputusan');
    //         if ($file->isValid()) {
    //             $path = $file->store('public/relaaspemberitahuanputusan');
    //             $relaaspemberitahuanputusan = Storage::url($path);
    //         } else {
    //             throw new \Exception('Invalid file uploaded for relaaspemberitahuanputusan.');
    //         }
    //     }

    //     $currentUser = Auth::user();
    //     $data = $request->all();
    //     $data['author'] = Auth::user()->id;
    //     $data['status'] = 'pending';
    //     $data['ktppemohon'] = $ktppemohon;
    //     $data['kkpemohon'] = $kkpemohon;
    //     $data['relaaspemberitahuanputusan'] = $relaaspemberitahuanputusan;

    //     $persalinan = Persalinan::create($data);

    //     // Kirim email
    //     Mail::to($request->email)->send(new PersalinanPersalinan($currentUser, $request->namapemohon, $request->noperkara));

    //     // Kirim WhatsApp
    //     $this->sendWhatsAppNotification($request->nohp, $request->namapemohon, $request->noperkara);

    //     return new PersalinanResource($persalinan->loadMissing(['writer:id,username']));
    // }

    private function sendWhatsAppNotification($phoneNumber, $namaPemohon, $noPerkara)
    {
        $message = "Halo $namaPemohon, permohonan Anda dengan nomor perkara $noPerkara telah diterima.";

        $response = Http::post('/send-whatsapp', [
            'phone' => $phoneNumber,
            'message' => $message
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to send WhatsApp message.');
        }
    }
    public function sendWhatsApp(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required',
            'message' => 'required',
        ]);

        $phone = $validated['phone'];
        $message = $validated['message'];

        $response = Http::post('http://localhost:3000/send-message', [
            'number' => $phone,
            'message' => $message
        ]);

        if ($response->failed()) {
            return response()->json(['message' => 'Failed to send WhatsApp message'], 500);
        }

        return response()->json(['message' => 'WhatsApp message sent successfully']);
    }
}
