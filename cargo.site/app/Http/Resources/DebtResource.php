<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class DebtResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
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
            'commission' => $this->commission,
            'notation' => $this->notation,
        ];
    }
}
