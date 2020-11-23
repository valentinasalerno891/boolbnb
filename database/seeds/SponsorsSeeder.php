<?php

use Illuminate\Database\Seeder;
use App\Sponsor;

class SponsorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hours24 = new Sponsor();
        $hours24->name = '24 ore';
        $hours24->price = '2.99';
        $hours24->duration = '24';
        $hours24->save();

        $hours72 = new Sponsor();
        $hours72->name = '72 ore';
        $hours72->price = '5.99';
        $hours72->duration = '72';
        $hours72->save();

        $hours144 = new Sponsor();
        $hours144->name = '144 ore';
        $hours144->price = '9.99';
        $hours144->duration = '144';
        $hours144->save();
    }
}
