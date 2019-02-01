<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->title,
        'price' => $faker->numberBetween($min = 1000, $max = 5000),
        'description' => $faker->text(100),
        'category_id' => function () {
        return factory(App\Category::class)->create()->id;

        }
    ];
});
