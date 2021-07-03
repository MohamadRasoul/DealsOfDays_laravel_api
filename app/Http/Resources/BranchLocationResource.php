<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'country'     => $this->country,
            'city'        => $this->city,
            'street'      => $this->street,
            'latitude'    => $this->latitude,
            'longitude'   => $this->longitude,
        ];
    }
}