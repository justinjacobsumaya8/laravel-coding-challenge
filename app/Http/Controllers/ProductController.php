<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
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
        $products = $this->productService->getAll();
        return DefaultResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productService->queryName($request->name);
        if ($product) {
            return response()->json([
                "message" => "Product already exists"   
            ], 422);
        }

        Product::create([
            "name" => $request->name,
            "brand" => $request->brand
        ]);

        return response()->json([
            "message" => "Product created successfully"   
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->find($id);
        return new DefaultResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = $this->productService->find($id);
        if (!$product) {
            return response()->json([
                "message" => "Product not found"   
            ], 404);
        }

        $product->brand = $request->brand;
        $product->save();

        return response()->json([
            "message" => "Product updated successfully"   
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->productService->find($id);
        $product->delete();

        return response()->json([
            "message" => "Product deleted successfully"   
        ], 200);
    }

    public function uploadImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = $this->productService->find($id);
        if (!$product) {
            return response()->json([
                "message" => "Product not found"   
            ], 404);
        }
        
        $imageName = time().'.'.$request->image->extension();  
        
        $request->image->move(public_path('images'), $imageName);

        $product->image = $imageName;
        $product->save();

        return response()->json([
            "message" => "Image uploaded successfully"   
        ], 200);
    }
}
