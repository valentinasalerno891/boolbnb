<?php

use Illuminate\Database\Seeder;
use App\Apartment;
use App\Message;
use Faker\Generator as Faker;


class MessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //Riempimento con valori faker 
    public function run(Faker $faker)
    {
        $apartments = Apartment::all();

        foreach($apartments as $apartment){
            $newMessage = new Message();
            $newMessage->email = $faker->safeEmail();
            $newMessage->body = $faker->realText($maxNbChars = 200);
            $newMessage->title = $faker->realText($maxNbChars = 50);
            $newMessage->created_at = $faker->date($format = 'd-M-Y', $max = 'now');
            $newMessage->hour = $faker->time($format = 'H:i:s', $max = 'now');

            $newMessage->apartment_id = $apartment->id;


            $newMessage->save();
        }

    }
}
