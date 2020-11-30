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
    //Riempimento con valori definiti
    public function run()
    {
        $category1 = new Category();
        $category1->name = 'Stanza Privata';
        $category1->save();
        $category2 = new Category();
        $category2->name = 'Tutta la casa';
        $category2->save();
        $category3 = new Category();
        $category3->name = 'Camera di Hotel';
        $category3->save();
        $category4 = new Category();
        $category4->name = 'Stanza Condivisa';
        $category4->save();
    }
}
