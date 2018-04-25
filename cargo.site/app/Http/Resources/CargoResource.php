<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CargoResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'type' => $this->type,
            'price' => $this->price,
            'client_name' => optional($this->client)->name,
            'count_place' => $this->count_place,
            'kg' => $this->kg,
            'fax_name' => $this->fax_name,
            'notation' => $this->notation,
        ];
    }
}
