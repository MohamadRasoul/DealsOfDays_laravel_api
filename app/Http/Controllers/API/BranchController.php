<?php

namespace App\Http\Controllers\API;

use App\Events\ShowBranch;
use App\Http\Controllers\Controller;
use App\Branch;
use App\Http\Resources\BranchResource;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BranchController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);

    }
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $branches = Branch::orderBy('rating')->paginate(10);
	    return BranchResource::collection($branches);
    }

    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $companyId )
    {


	    // $this->authorize('create' ,[Branch::class, $companyId]);

	    $data = $this->dataValidate($companyId);

	    $branch = Branch::create($data);
	    
        return new BranchResource($branch);


    }

    /*
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {

		Event(new ShowBranch($branch));

	    return new BranchResource($branch);
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
		$this->authorize('update', $branch);

	    $branch->update($this->dataValidate());

	    return response()->json('Your branch Is edite');

    }

    /*
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        $images = Array();
        if($branch->offers())
        {
            foreach($branch->offers as $offer)
            {
                if($offer->has('images'))
                {
                    foreach($offer->images as $image)
                    {
                        $images[] = $image->offer_image_path;
                    } 
                } 
            } 

        }
        $this->authorize('delete', $branch);
	   // Storage::disk('image_upload')->deleteDirectory('branch/' . $branch->id);
        $branch->delete();
	    return $images;

    }

    private function dataValidate($companyId = null)
    {
	    $user = auth('api')->user();

	    $data = request()->validate([
		    'name'            =>  '',
		    'latitude'        =>  '',
            'longitude'       =>  '',
            'country'         =>  '',
            'city'            =>  '',
            'street'          =>  '',
            
		    'openAt_closeAt'  =>  '',
		    'description'     =>  '',
		    'phoneNumber'     =>  '',
            'url'            =>  '',
	    ]);

	    $data['user_id'] = $user->id;
	    if(!is_null($companyId))
	    {
		    $data['company_id'] = $companyId;
	    }
	    //$company->image        =  request();
		return $data;
    }

}



// "name"       :  ""
// "location1"  :  ""
// "location2"  :  ""
// "image"      :  ""
// "rating"     :  ""
// "openAt"     :  ""
// "closeAt"    :  ""
// "description":  ""
// "phoneNumber":  ""
// "company_id" :  ""














