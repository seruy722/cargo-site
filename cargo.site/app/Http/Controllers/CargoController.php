<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Debt;
use App\Client;
use Illuminate\Http\Request;

class CargoController extends Controller
{

    public function home()
    {
        return view('vueApp');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cargos()
    {
        return Cargo::orderBy('created_at', 'DESC')->get();
    }

    public function debts()
    {
        return Debt::orderBy('created_at', 'DESC')->get();
    }

    public function search(Request $request)
    {
        $key = $request->keywords;

        if ($request->date1) {
            $date1 = date('Y-m-d', strtotime($request->date1));
        } else {
            $date1 = date('Y-m-d', strtotime('01-01-2000'));
        }
        if ($request->date2) {
            $date2 = date('Y-m-d', strtotime($request->date2));
        } else {
            $date2 = date(now());
        }
        if ($request->table === 'cargos') {
            return Cargo::where('client_id', 'LIKE', '%' . $key . '%')->whereDate('created_at', '>=', $date1)->whereDate('created_at', '<=', $date2)->orderBy('created_at', 'DESC')->get();
        } else {
            return Debt::where('client_id', 'LIKE', '%' . $key . '%')->whereDate('created_at', '>=', $date1)->whereDate('created_at', '<=', $date2)->orderBy('created_at', 'DESC')->get();
        }

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
