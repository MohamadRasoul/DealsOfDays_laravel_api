<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoponResource extends JsonResource
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
            'id'          =>$this->id,
            'copon'       =>strval( $this->copon ) ,
            'active'      =>$this->active,
            'created_at'  =>$this->created_at,
            'updated_at'  =>$this->updated_at,
            'user_id'     =>$this->user_id,
            'offer_id'    =>$this->offer_id  
        ];
    }
}
