<?php

namespace App\Http\Controllers\Persalinan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Persalinan\Persalinan;
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
        ]);
        $currentUser = Auth::user();


        $request['author'] = Auth::user()->id;

        $comment =Persalinan::create($request->all());

        Mail::to($request->email)->send(new PersalinanPersalinan($currentUser, $request->namapemohon,$request->noperkara));

        return new PersalinanResource($comment->loadMissing(['writer:id,username']));
    }
}
