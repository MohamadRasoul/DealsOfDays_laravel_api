<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProirityOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $offerImage = $this->images()->first();
       
        // return parent::toArray($request);
        return [
            'id'              =>  $this->id, 
            'offer'           =>  $this->offer,
            'company_name'          =>  $this->branches()->first()->company->name,
            
            'image'           =>  $offerImage['offer_image_path'],

        ];
    }

}
