<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function paginate(int $pagination = 5)
    {
        return Product::paginate($pagination);
    }

    public function findOrFail(string $id)
    {
        return Product::findOrFail($id);
    }

    public function uploadImage(object $image, Product $product)
    {
        $filePath = "/images/products";
        if ($product->image) {
            Storage::disk('public')->delete("{$filePath}/{$product->image}");
        }

        $imageName = time() . '.' . $image->extension();
        Storage::disk('public')->put("{$filePath}/{$imageName}", File::get($image));

        $product->image = $imageName;
        $product->save();

        return $product;
    }
}