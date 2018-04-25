<?php

use App\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Client::truncate();
        DB::statement("SET foreign_key_checks=1");
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            Client::create([
                'name' => $faker->userName,
                'email' => $faker->email,
                'phone' => $faker->tollFreePhoneNumber,
                'city' => $faker->city,
            ]);
        }
    }
}
