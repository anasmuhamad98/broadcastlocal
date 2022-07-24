<?php

namespace App\Http\Controllers;

use App\Events\NewEksesais;
use App\Models\CallsignEksesais;
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

    public function getcallsign(Request $request, $eksesaisId)
    {
        $eksesais = Eksesais::find($eksesaisId);
        return $eksesais->callsigns;
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
        $generalchatroom->name = 'TG 31.0';
        $generalchatroom->shortform = 'M7';
        $generalchatroom->isShow = 1;
        $generalchatroom->save();

        $generalchatroom->users()->attach($senaraiKapalTerlibat);
        $callsign1s = $request->callsign1;
        $callsign2s = $request->callsign2;
        foreach ($callsign1s as $index => $callsign1) {
            if ($callsign1 && $callsign2s[$index]) {
                $callsigneksesais = new CallsignEksesais();
                $callsigneksesais->eksesais_id = $eksesais->id;
                $callsigneksesais->callsign1 = $callsign1;
                $callsigneksesais->callsign2 = $callsign2s[$index];
                $callsigneksesais->save();
            }
        };

        // broadcast(new EventsNewChatMessage($newMessage))->toOthers();
        broadcast(new NewEksesais())->toOthers();
        return response()->json(['success' => true]);
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
