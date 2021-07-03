<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Company;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\CompanyBranchResource;


class CompanyController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'indexWithPaginate', 'show']]);
    }


	

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$companies = Company::inRandomOrder()->get();
	    return CompanyResource::collection($companies);
    }


	public function indexWithPaginate()
    {
	    $companies = Company::inRandomOrder()->paginate(4);
	    $collection = $companies->getCollection();
	    return CompanyResource::collection($collection);
    }



    public function indexUserCompany()
    {
        $user = auth('api')->user();
        $companies = $user->companies;
	    
	    return CompanyResource::collection($companies);
    }

	// public function indexOfferToThisCompany(Company $company)
    // {

    //     $branches = Branch::whereComapny_id($company->id )->get();
    //     $offers = Offer::whereBranch_id($company->id )->orderBy('views')->paginate(5);
	// 	$collection = $offers->getCollection();
	//     return HomeOfferResource::collection($collection);
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		 	
        $company = Company::create($this->dataValidate());
		$this->storeImage($company);
		
        // app()->call('App\Http\Controllers\API\BranchController@store' ,['companyId' => $company->id]);
		//return redirect()->route('posts.index');
		return new CompanyBranchResource($company); 

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
		
	    return new CompanyBranchResource($company); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
	    $company->update($this->dataValidate());
	    $this->storeImage($company);

	    return response()->json('Your Company Is edite');

    }

    /*
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
		$images = [
			$company->image,
			$company->cover,
		];
		// dd($images);
		
		if($company->has('branches'))
		{
			foreach($company->branches as $branch)
			{
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
						$offer->delete();
					} 

				}
			}
		}
		// dd($images);
	    // Storage::disk('image_upload')->deleteDirectory('company/' . $company->id);
	    $company->delete();
	    return $images;

    }

    private function dataValidate()
    {
	    $user = auth('api')->user();
		
		$data = request()->validate([
			'name'            =>  'required|min:3|max:25',
			'image'           =>  'sometimes',
			'cover'           =>  'sometimes',
		]);

		$data['user_id'] = $user->id;

		return $data;
		
	    // if(request()->ismethod('PUT')||request()->ismethod('PATCH'))
	    // {
		//     $data['user_id'] = $user->id;
		// 	return $data;
	    // }


    }

	private function storeImage($company)
	{
		// request()->validate([
		// 	'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
		// ]);
		// //delete All image before  update
		// $allImage = Storage::disk('image_upload')->allFiles('company/' . $company->id);
		// Storage::disk('image_upload')->delete($allImage);

		
		if (request()->has('image'))
		{
			$image = request()->image;
			// Storage::makeDirectory('company/' . $company->id);
			
			// $image_name = 'image_'. time() .'_'. $image->getClientOriginalName() ;
			// $path = '/images/company/' . $company->id;
			
			// Storage::disk('image_upload')->putFileAs(
			// 	'company/'. $company->id,
			// 	$image,
			// 	$image_name
			// );
			
			// $company->image = $path . '/' . $image_name;
			$company->image = $image;
			$company->save();
		}
			
		
		if (request()->has('cover'))
		{
			$cover = request()->cover;
			// Storage::makeDirectory('company/' . $company->id);

			// $cover_name ='cover_' . time() .'_'. $cover->getClientOriginalName() ;
			// $path = '/images/company/' . $company->id;

			// Storage::disk('image_upload')->putFileAs(
			// 	'company/'. $company->id,
			// 	$cover,
			// 	$cover_name
			// );

			// $company->cover = $path . '/' . $cover_name;
			$company->cover = $cover;
			$company->save();


		}

	}

	

}


// "name"            :  "Weimann, DuBuque and Welch",
// "mainLocation"    :  "",
// "location1"       :  "169.4",
// "location2"       :  "3.99402111",
// "image"           :  "",
// "rating"          :  "2",
// "openAt"          :  "2",
// "closeAt"         :  "7",
// "description"     :  "Ut eos aut error iste excepturi ut culpa. Quas magnam itaque quae esse. Incidunt sapiente eveniet molestiae repudiandae aspernatur delectus. Delectus nihil eum eligendi molestiae a aspernatur.",
// "phoneNumber"     :  "582-217-4476 x08674"