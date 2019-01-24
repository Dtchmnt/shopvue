<?php

namespace App\Repositories;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class EloquentProduct implements ProductRepository
{
    protected $product;
    protected $category;

    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    public function getAll()
    {
        return $this->product->with('category')->orderBy('created_at', 'desc')->paginate(6);
    }

    public function getById(int $id): Product
    {
        return $this->product->with('category')->findOrFail($id);
    }

    public function getByCategory(int $id): Category
    {
        return $this->category->with('product')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $product = $request->isMethod('put') ? $this->product->findOrFail($request->id) : new Product;

        $product->id = $request->input('id');
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        if($product->save()) {
            return new Product($product);
        }

    }

    public function deleteProduct($id, Request $request)
    {
        $deleteProduct = $this->product->findOrFail($id);

        $deleteProduct->name = $request->name;
        $deleteProduct->category_id = $request->category_id;
        $deleteProduct->price = $request->price;
        $deleteProduct->description = $request->description;

        $deleteProduct->delete();

        return $deleteProduct;


    }
}