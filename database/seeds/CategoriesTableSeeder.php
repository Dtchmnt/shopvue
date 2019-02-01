<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Процессор',],
            ['name' => 'Видеокарта',],
            ['name' => 'Материнская плата',],
            ['name' => 'Оперативная память',],
        ];
        Category::insert($data);
    }
}
