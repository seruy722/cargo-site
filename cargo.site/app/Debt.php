<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillabe = ['number_bag', 'client_id', 'count_place', 'kg', 'shop_name', 'inventory', 'count_sings', 'code_place', 'barnd', 'fax_name', 'notation'];
    public function clients()
    {
        return $this->belongsTo(Client::class);
    }
}
