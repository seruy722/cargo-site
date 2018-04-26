<?php

namespace App\Http\Controllers\Api;
use App\Debt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DebtResource;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $debts = Debt::get();
        return DebtResource::collection($debts);
    }

    public function show($id)
    {
        return new DebtResource(Debt::find($id));
    }
    public function search(Request $request)
    {
        $key = $request->keyword;
        if ($request->date1) {
            $date1 = date('Y-m-d', strtotime($request->date1));
        } else {
            $date1 = date('Y-m-d', strtotime('1900-01-01'));
        }
        if ($request->date2) {
            $date2 = date('Y-m-d', strtotime($request->date2));
        } else {
            $date2 = date(now());
        }

        if ($key) {
            $data = Debt::where('client_id', $key)->whereDate('created_at', '>=', $date1)->whereDate('created_at', '<=', $date2)->get();
        } else {
            $data = Debt::whereDate('created_at', '>=', $date1)->whereDate('created_at', '<=', $date2)->get();
        }
        return DebtResource::collection($data);

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
