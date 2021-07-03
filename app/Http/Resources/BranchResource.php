<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
        $branchCompany = $this->company()->first();
        // dd($branchCompany);

        return[
            'id'            =>$this->id,
            'name'          =>$this->name,
            'latitude'      =>$this->latitude,
            'longitude'     =>$this->longitude,
            'country'       =>$this->country,
            'city'          =>$this->city,
            'street'        =>$this->street,
            'view'          =>$this->view,
            'openAt_closeAt'=>$this->openAt_closeAt,
            'description'   =>$this->description,
            'phoneNumber'   =>$this->phoneNumber,
            'companyName'   =>  $branchCompany->name,
            'companyImage'  =>  $branchCompany->image,
            
			'isfollowing'   =>$this->isFollow(),

            'url'           =>$this->url,
            'created_at'    =>$this->created_at,
            'updated_at'    =>$this->updated_at,
            'company_id'    =>$this->company_id,
            'user_id'       =>$this->user_id,
            'myBranch'      =>$this->myBranch(),
        ];
    }

    public function isFollow()
	{
		$user = auth('api')->user();
		
		if(is_null($user))
		{
			return false;
		}
		else
		{
			if(is_null($user->branchsFollow->find($this->id)))
			{
				return false;
			} else
			{
				return true;
			}
		}
    }
    
    public function mybranch()
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
