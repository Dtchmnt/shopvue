<?php

namespace App\Http\Controllers\API;

use App\Repositories\EloquentProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class Product_CategoryController extends Controller
{

    public function getAll(EloquentProduct $product)
    {
        return response()->json($product->getAll());
    }

    public function getById(EloquentProduct $product, $id)
    {
        try {
            return response()->json($product->getById($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }

    }

    public function getByCategory(EloquentProduct $product, $id)
    {
        try {
            $collection = ($product->getByCategory($id));
            return response()->json($collection);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function store(EloquentProduct $product, request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|max:255',
                'category_id' => 'required',
                'price' => 'required|max:30',
                'description' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
        try {
            return response()->json($product->store($request));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function deleteProduct(EloquentProduct $product, $id, request $request)
    {
        try {
            return response()->json($product->deleteProduct($id, $request));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
