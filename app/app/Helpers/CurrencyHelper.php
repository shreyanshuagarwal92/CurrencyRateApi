<?php

namespace App\Helpers;

/**
 * Helper functions for CurrencyRate Controller
 */
class CurrencyHelper
{
    /**
     * Parse the data from database to create a response for API
     * @param array $currencyRates Array of Objects of each row in database
     * @return array
     */
    public static function getCurrencyResponse(array $currencyRates)
    {
        $response = [];
        foreach ($currencyRates as $currObj) {
            $newObj = [
                'rate' => $currObj['rate'],
                'date' => $currObj['date'],
            ];
            $response[$currObj['currency_code']][] = $newObj;
        }
        return $response;
    }
}
