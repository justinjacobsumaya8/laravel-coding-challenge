<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductImageUploadRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\DefaultResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->paginate(5);
        return DefaultResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        Product::create([
            "name" => $request->name,
            "brand" => $request->brand
        ]);

        return response()->json([
            "data" => "Product created successfully"   
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->findOrFail($id);
        return new DefaultResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, string $id)
    {
        $product = $this->productService->findOrFail($id);

        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->save();

        return response()->json([
            "data" => "Product updated successfully"   
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productService->findOrFail($id)->delete();

        return response()->json([
            "message" => "Product deleted successfully"   
        ], 200);
    }

    public function uploadImage(ProductImageUploadRequest $request, $id)
    {
        $product = $this->productService->findOrFail($id);
        $product = $this->productService->uploadImage($request->image, $product);

        return response()->json([
            "data" => "Image uploaded successfully"   
        ], 200);
    }
}
