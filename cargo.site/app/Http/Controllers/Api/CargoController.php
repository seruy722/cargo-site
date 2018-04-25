<?php

namespace App\Http\Controllers\Api;

use App\Cargo;
use App\Http\Controllers\Controller;
use App\Http\Resources\CargoResource;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        $cargos = Cargo::get();
        return CargoResource::collection($cargos);
    }
    public function show($id)
    {
        return new CargoResource(Cargo::find($id));
    }
    public function search(Request $request)
    {
        $key = $request->keyword;
        if ($request->date1) {
            $date1 = date('Y-m-d', strtotime($request->date1));
        } else {
            $date1 = date('Y-m-d', time());
        }
        if ($request->date2) {
            $date2 = date('Y-m-d', strtotime($request->date2));
        } else {
            $date2 = date(now());
        }
        if($key){
            $data = Cargo::where('client_id', $key)->get();
        }else{
            $data = Cargo::all();
        }
        return CargoResource::collection($data);

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
