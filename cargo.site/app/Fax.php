<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fax extends Model
{
    protected $table = 'faxes';
    protected $fillable = ['number_bag','client_id','count_place','kg','shop_name','inventory','count_sings','code_place','barnd','fax_name','notation'];
}
