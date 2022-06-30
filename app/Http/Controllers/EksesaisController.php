<?php

namespace App\Http\Controllers;

use App\Models\Eksesais;
use Illuminate\Http\Request;

class EksesaisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Eksesais::all();
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
