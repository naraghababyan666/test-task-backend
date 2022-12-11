<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if(isset($data['includeProducts'])){
            if($data['includeProducts'] == 1){
                $categoryWithProduct = Category::query()->with('product')->get();
                if(!empty($categoryWithProduct)){
                    return response()->json(['success' => true, 'categories' => $categoryWithProduct]);
                }
                return response()->json(['success' => false, 'message' => 'Empty categories list']);
            }else if($data['includeProducts'] == 0){
                $categories= Category::all();
                if(!empty($categories)){
                    return response()->json(['success' => true, 'categories' => $categories]);
                }
                return response()->json(['success' => false, 'message' => 'Empty categories list']);
            }else{
                return response()->json(['success' => false, 'message' => 'Invalid query parameters']);

            }
        }else if(empty($data)){
            $categories= Category::all();
            if(!empty($categories)){
                return response()->json(['success' => true, 'categories' => $categories]);
            }
            return response()->json(['success' => false, 'message' => 'Empty categories list']);
        }else if(!isset($data['includeProducts'])){
            return response()->json(['success' => false, 'message' => 'Invalid query parameters']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = ['name' => 'required|min:4'];
        if(isset($request->all()['parent_id'])){
            $data['parent_id'] = 'numeric';
        }
        $validated = Validator::make($request->all(), $data);
        if($validated->errors()->count() == 0) {
            $newCategory = Category::query()->create($validated->validated());
            return response()->json(['success' => true, 'data' => $newCategory]);
        }else{
            return response()->json(['success' => true, 'data' => $validated->errors()]);

        }
        return response()->json(['success' => false, 'message' => 'Invalid data']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id, Request $request)
    {
        $data = $request->all();
        if(isset($data['includeProducts'])){
            if($data['includeProducts'] == 1){
                $categoryCurrentWithProduct = Category::query()->where('id', $id)->with('product')->first();
                if(!empty($categoryCurrentWithProduct)){
                    return response()->json(['success' => true, 'categories' => $categoryCurrentWithProduct]);
                }
                return response()->json(['success' => false, 'message' => 'Category not found']);
            }else if($data['includeProducts'] == 0){
                $category = Category::query()->where('id', $id)->with('product')->first();
                if(!is_null($category)){
                    return response()->json(['success' => true, 'data' => $category]);
                }
                return response()->json(['success' => false, 'message' => 'Category not found']);
            }else{
                return response()->json(['success' => false, 'message' => 'Invalid query parameters']);

            }
        }else if(empty($data)){
            $category = Category::query()->find($id);
            if(!is_null($category)){
                return response()->json(['success' => true, 'data' => $category]);
            }
            return response()->json(['success' => false, 'message' => 'Category not found']);
        }else if(!isset($data['includeProducts'])){
            return response()->json(['success' => false, 'message' => 'Invalid query parameters']);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $category = Category::query()->find($id);
        if(!is_null($category)){
            $data = ['name' => 'required|min:4'];
            if(isset($request->all()['parent_id'])){
                $data['parent_id'] = 'numeric';
            }
            $validated = Validator::make($request->all(), $data);
            if($validated->errors()->count() == 0) {
                Category::query()->find($id)->update($validated->validated());
                return response()->json(['success' => true, 'message' => 'Category successfully updated']);
            }
            return response()->json(['success' => false, 'message' => 'Invalid data']);
        }
        return response()->json(['success' => false, 'message' => 'Category not found']);
    }

    public function getProducts($id, Request $request){
        $param = $request->all();
        if(isset($param['includeChildren'])){
            if($param['includeChildren'] == 1){
                $categoriesWithChilds = Category::query()->where('id', $id)->with('child_category')->get();
                $products = [];
                foreach ($categoriesWithChilds as $item){
                    if(!empty($item['child_category'])){
                        foreach ($item['child_category'] as $child){
                            $productByChildId = Product::query()->where('category_id', $child['id'])->get();
                            if(count($productByChildId) != 0){
                                foreach ($productByChildId as $prod){
                                    $products[] = $prod;
                                }
                            }
                        }
                        $item['products'] = $products;
                    }
                }
                return response()->json(['success' => true, 'data' => $categoriesWithChilds]);

            }else if($param['includeChildren'] == 0){
                $categories = Category::query()->where('id', $id)->with('product')->get();
                if(count($categories) != 0){
                    return response()->json(['success' => true, 'data' => $categories]);
                }
                return response()->json(['success' => false, 'message' => 'Empty category list']);
            }else{
                return response()->json(['success' => false, 'message' => 'Invalid query parameters']);

            }
        }else if(empty($param)){
            $categories = Category::query()->where('id', $id)->with('product')->get();
            if(count($categories) != 0){
                return response()->json(['success' => true, 'data' => $categories]);
            }
            return response()->json(['success' => false, 'message' => 'Empty category list']);
        }else if(!isset($param['includeChildren'])){
            return response()->json(['success' => false, 'message' => 'Invalid query parameters']);
        }








    }

}
