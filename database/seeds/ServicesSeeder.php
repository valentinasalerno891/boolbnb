<?php

use Illuminate\Database\Seeder;
use App\Service;


class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wifi = new Service();
        $wifi->name = 'Wifi';
        $wifi->save();

        $parking = new Service();
        $parking->name = 'Posto Macchina';
        $parking->save();

        $swimming_pool = new Service();
        $swimming_pool->name = 'Piscina';
        $swimming_pool->save();

        $concierge = new Service();
        $concierge->name = 'Portineria';
        $concierge->save();

        $sauna = new Service();
        $sauna->name = 'Sauna';
        $sauna->save();

        $sea_view = new Service();
        $sea_view->name = 'Vista Mare';
        $sea_view->save();

    }
}
