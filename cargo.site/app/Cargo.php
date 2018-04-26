<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillabe = ['type', 'price', 'client_id', 'count_place', 'kg', 'fax_name', 'notation'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
