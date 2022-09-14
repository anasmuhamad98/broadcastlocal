<?php

namespace App\Http\Controllers;

use App\Events\NewEksesais;
use App\Models\CallsignEksesais;
use App\Models\ChatRoom;
use App\Models\Eksesais;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class EksesaisController extends Controller
{

    public function authuser()
    {
        if (!Auth::check()) {
            $user = User::find(38);
            Auth::login($user);
        };
        return redirect('/eksesais');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Eksesais');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function geteksesais()
    {
        $user = User::find(Auth::id());
        return $user->eksesais;
        // $eksesaislist = Eksesais::with(['users' => function ($query) {
        //     $query->select('users.id')->where('users.id', Auth::id());
        // }])->get();
        // return $eksesaislist->whereNotNull('users');
    }

    public function getcallsign(Request $request)
    {
        return CallsignEksesais::whereDate('tarikh',  Carbon::now())->get();
        // $eksesais = Eksesais::find($eksesaisId);
        // return $eksesais->callsigns;
    }

    public function getcallsigneksesais(Request $request)
    {
        $callsigneksesais = CallsignEksesais::whereDate('tarikh', '>=', Carbon::now())->whereDate('tarikh', '<=', Carbon::now()->addDay(4))->get();
        $callsigngroup = CallsignEksesais::select('callsign1')->whereDate('tarikh', '>=', Carbon::now())->whereDate('tarikh', '<=', Carbon::now()->addDay(4))->groupBy('callsign1')->get();
        return response()->json(['callsigneksesais' => $callsigneksesais, 'callsigngroup' => $callsigngroup]);
    }

    public function getusersonallroomineksesais($eksesaisId)
    {

        $user = User::find(Auth::id());
        return $user->rooms()->with('users')->where('eksesais_id', $eksesaisId)->get();
        // return Eksesais::find($eksesaisId)->rooms()->with('users')->get();
    }

    public function eksesaisdetail($eksesaisId)
    {
        $eksesaisdetail = Eksesais::find($eksesaisId);

        return $eksesaisdetail;
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
        $generalchatroom->name = $request->firstgroupname;
        $generalchatroom->shortform = $request->firstgroupcallsign;
        $generalchatroom->isShow = 1;
        $generalchatroom->save();

        $generalchatroom->users()->attach($senaraiKapalTerlibat);


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
