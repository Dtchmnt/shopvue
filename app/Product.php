<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'id',
        'name',
        'category_id',
        'price',
        'description',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
