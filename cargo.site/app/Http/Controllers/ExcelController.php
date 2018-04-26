<?php

namespace App\Http\Controllers;

use App\Client;
use Excel;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function getImport(Request $request)
    {
        // dd($request->all());
        if ($request->hasFile('excel')) {
            Excel::load($request->file('excel')->getRealPath(), function ($reader) {
                foreach ($reader->toArray() as $key => $row) {
                    $data['name'] = $row['imya'];
                    if (!empty($data)) {
                        Client::create($data);
                    }
                }
            });
        }
        return redirect('/');
    }
}
