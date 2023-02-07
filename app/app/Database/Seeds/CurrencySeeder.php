<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) { //to add 10 currencies. Change limit as desired
            $this->db->table('currencies')->insert($this->generateCurrencies());
        }
    }

    private function generateCurrencies(): array
    {
        $faker = Factory::create();
        return [
            'currency_code' => $faker->currencyCode,
        ];
    }
}
