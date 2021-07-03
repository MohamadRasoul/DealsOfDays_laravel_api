<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoponOfferResource extends JsonResource
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
            'id'              =>  $this->id,
            'offer'           =>  $this->offer,
			'offerPrecentage' =>  $this->offerPrecentage,
			'startDate'       =>  $this->startDate,
            'endDate'         =>  $this->endDate,

            'company-image'   =>  $this->branches()->first()->company->image,
            'copon'           =>  $this->pivot->copon,
            'copon-active'    =>  $this->pivot->active
        ];
    }
}
