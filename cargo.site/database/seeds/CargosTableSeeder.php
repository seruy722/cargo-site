<?php

use App\Cargo;
use Illuminate\Database\Seeder;

class CargosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Cargo::truncate();
        DB::statement("SET foreign_key_checks=1");
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            Cargo::create([
                'type' => 'Оплата',
                'price' => $faker->randomNumber(3),
                'client_id' => rand(1, 50),
                'count_place' => rand(1, 20),
                'kg' => $faker->randomNumber(3),
                'fax_name' => $faker->streetAddress,
                'notation' => $faker->word
            ]);
        }
        for ($i = 0; $i < 50; $i++) {
            Cargo::create([
                'type' => 'Долг',
                'price' => $faker->randomNumber(3) * -1,
                'client_id' => rand(1, 50),
                'count_place' => rand(1, 20),
                'kg' => $faker->randomNumber(3),
                'fax_name' => $faker->streetAddress,
                'notation' => $faker->word
            ]);
        }
    }
}
