<?php

namespace App\Http\Controllers;

use App\Models\Callsign;
use App\Models\CallsignEksesais;
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
            $query->where('tarikh',  Carbon::now());
        }])->get();
    }


    public function senaraikapaldalameksesais($eksesaisId)
    {
        return  Eksesais::find($eksesaisId)->users()->with('callsign')->get();

    }

    public function savecallsign(Request $request)
    {
        // return $request->tarikhhari;
        $callsign1s = $request->callsign1;
        $callsign2s = $request->callsign2;
        foreach ($callsign1s as $index => $callsign1) {
            if ($callsign1 && $callsign2s[$index]) {
                $callsigneksesais = new CallsignEksesais();
                $callsigneksesais->tarikh = $request->tarikhhari;
                $callsigneksesais->callsign1 = $callsign1;
                $callsigneksesais->callsign2 = $callsign2s[$index];
                $callsigneksesais->save();
            }
        };

        $callsignkapals = $request->callsignkapal;
        foreach ($callsignkapals as $index => $callsignkapal) {
            if ($callsignkapal) {
                $data = new Callsign();
                $data->user_id =  $request->idKapal[$index];
                $data->tarikh = $request->tarikhhari;
                $data->callsign = $callsignkapal;
                $data->save();
            }
        }

        // return response()->json(['teadtasd' => $request->callsignkapal, 'sagokwof' => $request->idKapal]);
    }

    public function getcallsign()
    {
        return User::with(['callsigns' => function ($query) {
            $query->whereDate('tarikh', '>=' ,Carbon::now())->whereDate('tarikh', '<=', Carbon::now()->addDay(4));
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
