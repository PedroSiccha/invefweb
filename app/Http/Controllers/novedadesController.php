<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class novedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cli()
    {
        $ocupacion = \DB::SELECT('SELECT * FROM ocupacion');
        $recomendacion = \DB::SELECT('SELECT * FROM recomendacion');
        $tipodoc = \DB::SELECT('SELECT * FROM tipodocide');
        $departamento = \DB::SELECT('SELECT * FROM departamento');
        $provincia = \DB::SELECT('SELECT * FROM provincia');
        $distrito = \DB::SELECT('SELECT * FROM distrito');
        return view('web.registroSorteo', compact('ocupacion', 'recomendacion', 'tipodoc', 'departamento' ,'provincia', 'distrito'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
