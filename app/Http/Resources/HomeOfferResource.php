<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class HomeOfferResource extends JsonResource
{


    //     public function __construct($resource, $lastPage)
    // {
    //     parent::__construct($resource);
    //     $this->resource = $resource;
    //     $this->lastPage = $lastPage;
    // }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $offerImage = $this->images()->first();
        $companyImage = $this->branches()->first() ? $this->branches()->first()->company->image : null;
        $arrayData = [
            'id'              =>  $this->id,
            'offer'           =>  $this->offer,
            'offerPrecentage' =>  $this->offerPrecentage,
            'oldPrice'        =>  $this->oldPrice,
            'startDate'       =>  $this->startDate,
            'endDate'         =>  $this->endDate,
            'rating'          =>  $this->rating,
            'views'           =>  $this->views,
            'curency'         =>  $this->curency,

            'category'        =>  new CategoryResource($this->category),
            'image'           =>  $offerImage['offer_image_path'],
            'company_image'   =>  $companyImage,
        ];


        if ($this->isOnline) {
            $arrayData['city'] = 'Online';
        } else {
            $arrayData['city'] = $this->branches->first() ? $this->branches->first()->city : null;
        }
        return $arrayData;
    }
}
