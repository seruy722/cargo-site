<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $fillable = ['type', 'price', 'client_id', 'count_place', 'kg', 'fax_name', 'notation','created_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
