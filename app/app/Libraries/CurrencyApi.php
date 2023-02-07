<?php

namespace App\Libraries;

use CodeIgniter\Config\Services;
use Exception;

/**
 * CurrencyApi class to fetch currency rate in case not found in database
 */
class CurrencyApi
{

    /**
     * Fetch currency rates from external API
     * @param string $currencyCode Currency code to be fetched
     * @param string $startPeriod Start date for the currency rate period
     * @param string $endPeriod End date for the currency rate period
     * 
     * @return array|bool
     */
    public function getHistoricalDataForACodeFromAPI(string $currencyCode = null, string $startPeriod, string $endPeriod = null): array|bool
    {
        $url = $this->getAPIUrl($currencyCode, $startPeriod,  $endPeriod);
        $result = $this->getResponseFromAPI($url);
        return $result['rates'];
    }

    /**
     * Parse response from external API
     * @param string $url
     * 
     * @return array|Exception
     */
    private function getResponseFromAPI(string $url): array|Exception
    {
        $client = Services::curlrequest();
        $resonse = $client->request('GET', $url);
        if ($resonse->getBody()) return json_decode($resonse->getBody(), true);
        else throw new Exception('Currency API failed');
    }

    /**
     * @param string|null $currencyCode
     * @param string $startPeriod
     * @param string|null $endPeriod
     * 
     * @return string
     */
    private function getAPIUrl(string $currencyCode = null, string $startPeriod, string $endPeriod = null): string
    {
        $url = 'https://api.frankfurter.app/' . $startPeriod;
        if ($endPeriod) {
            $url .= '..' . $endPeriod;
        }
        if ($currencyCode) {
            $url .= '?to=' . $currencyCode;
        }
        return $url;
    }
}
