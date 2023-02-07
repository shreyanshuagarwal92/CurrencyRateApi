<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
use DateTime;
use DateInterval;

class CurrencyRateSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $currencyData = $this->db->table('currencies')->get()->getResult();
        $currencyCodes = [];

        foreach ($currencyData as $currencyObj) {
            array_push($currencyCodes, $currencyObj->currency_code);
        }

        foreach ($currencyCodes as $code) {
            $date = new DateTime();
            $dateTenDaysEarlier = new DateTime();
            $dateTenDaysEarlier->sub(new DateInterval('P10D'));
            while ($dateTenDaysEarlier <= $date) {
                $data = [
                    'currency_code' => $code,
                    'rate' => $faker->randomFloat(4, 0.1, 2.0),
                    'date' => $date->format('Y-m-d')
                ];
                $date->sub(new DateInterval('P1D'));
                $this->db->table('currency_rates')->insert($data);
            }
        }
    }
}
