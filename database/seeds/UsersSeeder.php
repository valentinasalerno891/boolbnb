<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Generator as Faker;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i<20; $i++){
            $newUser = new User();
            $newUser->name = $faker->firstName();
            $newUser->lastname = $faker->lastName();
            $newUser->email = $faker->safeEmail();
            $newUser->password = Hash::make('prova');
            $newUser->birthdate = $faker->date($format = 'Y-m-d', $max = 'now');

            $newUser->save();
        }
    }
}
