<?php

namespace App\Http\Controllers\Api;

use App\Debt;
use App\Http\Controllers\Controller;
use App\Http\Resources\DebtResource;
use Illuminate\Http\Request;

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
        return new DebtResource(Debt::findOrFail($id));
    }

    public function search(Request $request)
    {
        $key = $request->keyword;
        $type = $request->typeTable;
        if ($request->dateStart) {
            $dateStart = date('Y-m-d', strtotime($request->dateStart));
        } else {
            $dateStart = date('Y-m-d', strtotime('1900-01-01'));
        }
        if ($request->dateLast) {
            $dateLast = date('Y-m-d', strtotime($request->dateLast));
        } else {
            $dateLast = date(now());
        }
        if ($key && $type) {
            $data = Debt::where('type', $type)->where('client_id', $key)->whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateLast)->get();
        } elseif ($key) {
            $data = Debt::where('client_id', $key)->whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateLast)->get();
        } else if ($type) {
            $data = Debt::where('type', $type)->whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateLast)->get();
        } else {
            $data = Debt::whereDate('created_at', '>=', $dateStart)->whereDate('created_at', '<=', $dateLast)->get();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Debt::find($id);
        $data = $request->all();
        if ($post) {
            if ($data['type'] === 'Долг' && $this->sign($data['price']) >= 0) {
                $data['price'] = ($data['price'] * -1);
            } else if($data['type'] === 'Оплата' && $this->sign($data['price']) <= 0){
                $data['price'] = ($data['price'] * -1);
            }
            $post->update($data);
            return response()->json(['status' => 'success', 'msg' => 'Запись успешно обновлена']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Ошибка при обновлении записи']);
        }
    }

    public function sign( $number ) {
        return ( $number > 0 ) ? 1 : ( ( $number < 0 ) ? -1 : 0 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Debt::find($id);
        if($post){
            $post->delete();
            return response()->json(['status'=>'success','msg'=>'Запись успешно удалена']);
        }else{
            return response()->json(['status'=>'error','msg'=>'Ошибка при удалении записи']);
        }
    }
}
