<?php

namespace App\Http\Controllers;

use App\Models\Callsign;
use App\Models\Eksesais;
use App\Models\Kapal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KapalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with(['callsign' => function ($query) {
            $query->where('tarikhhari',  Carbon::now()->day);
        }])->get();
    }


    public function senaraikapaldalameksesais($eksesaisId)
    {
        return $kapaldalameksesais = Eksesais::find($eksesaisId)->users()->with('callsign')->get();

    }

    public function savecallsign(Request $request)
    {
        // return $request->tarikhhari;
        $callsignkapals = $request->callsignkapal;
        foreach ($callsignkapals as $index => $callsignkapal) {
            if ($callsignkapal) {
                $data = new Callsign();
                $data->user_id =  $request->idKapal[$index];
                $data->tarikhhari = $request->tarikhhari;
                $data->callsign = $callsignkapal;
                $data->save();
            }
        }
        // return response()->json(['teadtasd' => $request->callsignkapal, 'sagokwof' => $request->idKapal]);
    }

    public function getcallsign()
    {
        return User::with(['callsigns' => function ($query) {
            $query->where('tarikhhari', '>=' ,Carbon::now()->day)->where('tarikhhari', '<=', Carbon::now()->addDay(4)->day);
        }])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kapal  $kapal
     * @return \Illuminate\Http\Response
     */
    public function show(Kapal $kapal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kapal  $kapal
     * @return \Illuminate\Http\Response
     */
    public function edit(Kapal $kapal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kapal  $kapal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kapal $kapal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kapal  $kapal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kapal $kapal)
    {
        //
    }
}
