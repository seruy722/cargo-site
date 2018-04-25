<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use Excel;
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
