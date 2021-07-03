<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $reviewUser = $this->user;

        return [
            "id"            =>  $this->id ,
            "rating"        =>  $this->rating ,
            "description"   =>  $this->description ,
            'userName'      =>  $reviewUser->userName,
            'userImage'     =>  $reviewUser->image,
            "created_at"    =>  $this->created_at->toDateTimeString(),
            "updated_at"    =>  $this->updated_at->toDateTimeString() 
        ];
    }
}
