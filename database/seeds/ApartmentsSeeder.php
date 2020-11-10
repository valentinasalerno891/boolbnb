<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Apartment;
use Faker\Generator as Faker;


class ApartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = User::all();

        foreach ($users as $user){
            $newApartment = new Apartment();
            $newApartment->title = $faker->realText($maxNbChars = 50);
            $newApartment->rooms = $faker->numberBetween($min = 1, $max = 100);
            $newApartment->beds = $faker->numberBetween($min = 1, $max = 100);
            $newApartment->bathrooms = $faker->numberBetween($min = 1, $max = 100);
            $newApartment->square_meters = $faker->numberBetween($min = 1, $max = 500);
            $newApartment->image = $faker->imageUrl($width = 640, $height = 480);
            $newApartment->description = $faker->realText($maxNbChars = 500);
            $newApartment->available = 1;
            $newApartment->latitude = $faker->latitude();
            $newApartment->longitude = $faker->longitude();

            $newApartment->user_id = $user->id;
            $newApartment->category_id = $faker->numberBetween($min = 1, $max = 4);

            $newApartment->save();

        }
        
    }
}
