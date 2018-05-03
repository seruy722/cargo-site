<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = ['type','price','commission','notation','created_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
