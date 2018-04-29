<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = ['client_id', 'count_place', 'kg', 'notation'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
