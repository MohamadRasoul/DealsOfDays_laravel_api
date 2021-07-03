<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyBranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        dd(BranchResource::collection($this->branches));
        return [
            'id'            =>  $this->id,
            'name'          =>  $this->name,
            'image'         =>  $this->image,
            'cover'         =>  $this->cover,
            'created_at'    =>  $this->created_at,
            'updated_at'    =>  $this->updated_at,
            'branches'      =>  BranchResource::collection($this->branches),
            'myCompnay'     =>  $this->myCompany(),
        ];
    }
    public function myCompany()
	{
		
        $user = auth('api')->user();
        
		if(is_null($user))
		{
			return false;
		}
		else
		{
			if($user->id == $this->user_id)
			{
				return true;
			} else
			{
				return false;
			}
		}
	}
}
