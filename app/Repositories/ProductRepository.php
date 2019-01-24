<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Product;
use App\Category;

interface ProductRepository {

    /**
     * Get all works
     *
     * @return Collection
     */
    public function getAll();

    public function getById(int $id): product;

    public function getByCategory(int $id): category;

    public function store(Request $request);

    public function deleteProduct($id, Request $request);

}