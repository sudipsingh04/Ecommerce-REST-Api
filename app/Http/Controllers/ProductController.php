<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use App\Exceptions\ProductNotBelongsToUser;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCollection::collection(Product::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request, Product $product)
    {
        $prod = $product->create([
            'name'      => request()->name,
            'detail'    => request()->description,
            'price'     => request()->price,
            'stock'     => request()->stock,
            'discount'  => request()->discount
        ]);

        return response([
            'data' => new ProductResource($prod)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->productUserCheck($product);

        $request['detail'] = $request->description;
        unset($request['description']);

        $product->update($request->all());

        return response([
            'data' => new ProductResource($product)
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->productUserCheck($product);
        $product->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function productUserCheck($product)
    {
        if(Auth::id() !== $product->user_id){
            throw new ProductNotBelongsToUser;
        }
    }
}
