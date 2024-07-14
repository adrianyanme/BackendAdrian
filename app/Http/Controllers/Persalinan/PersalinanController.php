<?php

namespace App\Http\Controllers\Persalinan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Persalinan\PersalinanResource;
use App\Models\Persalinan\Persalinan;

class PersalinanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'streaming_id' => 'required|exists:streaming,id',
            'email' => 'required',
            'jenissalinan' => 'required',
            'putusanyangdiminta' => 'required',
            'namapemohon' => 'required',
            'nohp' => 'required',
            'statuspemohon' => 'required',
            'noperkara' => 'required',
        ]);

        $request['user_id'] = auth()->user()->id;

        $comment =Persalinan::create($request->all());

      
        return new PersalinanResource($comment->loadMissing(['commentator:id,username']));
    }
}
