<?php

use App\Debt;
use Illuminate\Database\Seeder;

class DebtsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Debt::truncate();
        DB::statement("SET foreign_key_checks=1");
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            Debt::create([
                'type' => 'Оплата',
                'price' => $faker->randomNumber(3),
                'client_id' => rand(1, 50),
                'commission' => $faker->randomNumber(2),
                'notation' => $faker->word
            ]);
        }
        for ($i = 0; $i < 50; $i++) {
            Debt::create([
                'type' => 'Долг',
                'price' => $faker->randomNumber(3) * -1,
                'client_id' => rand(1, 50),
                'commission' => $faker->randomNumber(2),
                'notation' => $faker->word
            ]);
        }
    }
}
