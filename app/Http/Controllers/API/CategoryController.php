<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Category;
use App\Offer;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\HomeOfferResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'indexWithPaginate', 'indexOfferToThisCategory', 'show']]);
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('views')->get();
	    return CategoryResource::collection($categories);
    }
    

    public function indexWithPaginate()
    {
	    $categories = Category::orderBy('views')->paginate(6);
	    $collection = $categories->getCollection();
	    return CategoryResource::collection($collection);
    }



    public function indexOfferToThisCategory(Category $category)
    {
        $offers = Offer::whereCategory_id($category->id )
        ->whereDate('endDate', '>=' ,Carbon::today()->toDateString())
		->whereDate('startDate', '<=' ,Carbon::today()->toDateString())
        ->orderBy('views')
        ->paginate(5);
		$collection = $offers->getCollection();
	    return HomeOfferResource::collection($collection);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $data = $this->dataValodate();
        Category::create($data);
		return response()->json('Your Category Is Add');
        
        
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        CategoryResource::withoutWrapping();
	    return new CategoryResource($category);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->update($this->dataValodate());
		return response()->json('Your Category Is Edit');
        
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete($category);

        return response()->json('Your Category Is Deleted');
    
    }
    
    public function dataValodate()
    {
	    return request()->validate([
		    'name'         =>   'required|min:3|max:25|unique:categories,name',
		    'categoryId'   =>   'required',
		    'color'        =>   '',
	    ]);
    }



}
