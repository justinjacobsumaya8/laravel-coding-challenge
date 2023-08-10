<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function getAll(int $paginate = 5)
    {
        return Product::paginate($paginate);
    }

    public function find(string $id)
    {
        return Product::find($id);
    }

    public function queryName(string $name)
    {
        return Product::where("name", $name)->first();
    }
}