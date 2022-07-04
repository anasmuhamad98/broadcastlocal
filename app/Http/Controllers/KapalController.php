<?php

namespace App\Http\Controllers;

use App\Models\Kapal;
use App\Models\User;
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
        return User::all();
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
