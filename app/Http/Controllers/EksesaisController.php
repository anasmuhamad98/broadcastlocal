<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Models\Eksesais;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EksesaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::id());
        return $user->eksesais;
        // $eksesaislist = Eksesais::with(['users' => function ($query) {
        //     $query->select('users.id')->where('users.id', Auth::id());
        // }])->get();
        // return $eksesaislist->whereNotNull('users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $senaraiKapalTerlibat = $request->senaraiKapalTerlibat;
        $eksesais = new Eksesais;
        $eksesais->Nama = $request->namaEksesais;
        $eksesais->save();

        // $senaraiKapalTerlibat =[10, 11];

        $eksesais->users()->attach($senaraiKapalTerlibat);

        $generalchatroom = new ChatRoom;
        $generalchatroom->eksesais_id = $eksesais->id;
        $generalchatroom->name = 'General';
        $generalchatroom->save();

        $generalchatroom->users()->attach($senaraiKapalTerlibat);

        return response()->json([ 'success' => true ]);
        // return response()->json([
        //     'data' => $namaEksesais,
        //     'asdasd' => $senaraiKapalTerlibat
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Eksesais  $eksesais
     * @return \Illuminate\Http\Response
     */
    public function show(Eksesais $eksesais)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Eksesais  $eksesais
     * @return \Illuminate\Http\Response
     */
    public function edit(Eksesais $eksesais)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Eksesais  $eksesais
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Eksesais $eksesais)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Eksesais  $eksesais
     * @return \Illuminate\Http\Response
     */
    public function destroy(Eksesais $eksesais)
    {
        //
    }
}
