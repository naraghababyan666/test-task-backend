<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products= Product::all();
        if(!empty($products)){
            return response()->json(['success' => true, 'products' => $products]);
        }
        return response()->json(['success' => false, 'message' => 'Empty categories list']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric|exists:categories,id'
        ]);
        if($validated->errors()->count() == 0) {
            $newProduct = Product::query()->create($validated->validated());
            return response()->json(['success' => true, 'data' => $newProduct]);
        }else{
            return response()->json(['success' => false, 'message' => $validated->errors()]);
        }
        return response()->json(['success' => false, 'message' => 'Invalid data']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::query()->find($id);
        if(!is_null($product)){
            return response()->json(['success' => true, 'data' => $product]);
        }
        return response()->json(['success' => false, 'message' => 'Category not found']);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::query()->find($id);
        if(!is_null($product)){
            $validated = Validator::make($request->all(), [
                'name' => 'required|min:4',
                'price' => 'required|numeric',
                'category_id' => 'required|numeric|exists:categories,id'
            ]);
            if($validated->errors()->count() == 0) {
                Product::query()->find($id)->update($validated->validated());
                return response()->json(['success' => true, 'message' => 'Product successfully updated']);
            }
            return response()->json(['success' => false, 'message' => 'Invalid data']);
        }
        return response()->json(['success' => false, 'message' => 'Category not found']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::query()->find($id);
        if(!is_null($product)){
            $product->delete();
            return response()->json(['success' => true, 'message' => 'Successfully deleted']);
        }
        return response()->json(['success'=> false, 'message' => 'Product not found']);
    }
}
