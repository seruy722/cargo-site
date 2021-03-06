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
        $need_date = date('d-m-Y',strtotime($this->created_at));
        return [
            'id' => $this->id,
            'created_at' => $need_date,
            'type' => $this->type,
            'price' => $this->price,
            'client_name' => optional($this->client)->name,
            'commission' => $this->commission,
            'notation' => $this->notation,
        ];
    }
}
