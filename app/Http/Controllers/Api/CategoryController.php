<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // return Product::all();
      // return response()->json(Product::all(), 200);
    //  return response(Product::paginate(10), 200);

    $offset = $request->has('offset') ? $request->query('offset') : 0;
    $limit = $request->has('limit') ? $request->query('limit') :  10;

    $qb = Category::query();
    if ($request->has('q'))
    $qb->where('name', 'like', '%' . $request->query('q') . '%');

    if ($request->has('sortBy'))
    $qb->orderBy($request->query('sortBy'), $request->query('sort','DESC'));

    $data = $qb->offset($offset)->limit($limit)->get();
    return $this->apiResponse(ResultType::Success, Category::all(), 'Categories fetched', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $input = $request->all();
      //  $product = Product::create($input);
      $category = new Category;
      $category->name = $request->name;
      $category->slug = Str::slug($request->name);
    //   $category->price = $request->price;
      $category->save();
      


      return $this->apiResponse(ResultType::Success, $category, 'Category created', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if($category){
            return $this->apiResponse(ResultType::Success, $category, 'Category Found', 200);
        }else {
            return $this->apiResponse(ResultType::Errors, 'Category not found', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        /*  $input = $request->all();
        $product->update($input); */
     
      $category->name = $request->name;
      $category->slug = Str::slug($request->name);
     // $category->price = $request->price;
      $category->save(); 
      


      return $this->apiResponse(ResultType::Success, $category, 'Category updated.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->apiResponse(ResultType::Success, null,'Category deleted.', 200);
    }

    public function custom1() {
      //  return Category::pluck('id', 'name');
        return Category::pluck('name', 'id');
    }
     public function report1() {
      
        return DB::table('product_categories as pc')
        ->selectRaw('c.name, COUNT(*) as total')
        ->join('categories as c', 'c.id', '=', 'pc.category_id')
        ->join('products as p', 'p.id', '=', 'pc.product_id')
        ->groupBy('c.name')
        ->orderByRaw('COUNT(*) DESC')
        ->get();
    }
}
