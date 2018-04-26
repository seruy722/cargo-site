<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'city'];

    public function cargos()
    {
        return $this->hasMany(Cargo::class);
    }

    public function debts()
    {
        return $this->hasMany(Dolgi::class);
    }

    public function fax()
    {
        return $this->hasMany(Fax::class);
    }
}
