<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1 = new Category();
        $category1->name = 'prova1';
        $category1->save();
        $category2 = new Category();
        $category2->name = 'prova2';
        $category2->save();
        $category3 = new Category();
        $category3->name = 'prova3';
        $category3->save();
        $category4 = new Category();
        $category4->name = 'prova4';
        $category4->save();

    }
}
