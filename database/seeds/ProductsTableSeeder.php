<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = DB::table('category')->select('id')->get();
        foreach ($sql as $category) {
            $random = mt_rand(1,5);
            factory(App\Product::class, $random)->create(['category_id' => $category->id]);
        }
    }
}
