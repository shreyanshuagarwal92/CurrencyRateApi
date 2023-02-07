<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\CurrencyApi;
use Exception;

/**
 * Model for currency_rate table
 */
class CurrencyRateModel extends Model
{
    protected $table = 'currency_rates';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'date', 'currency_code', 'rate',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * @return array
     */
    public function getAllCurrencies(): array
    {
        $builder = $this->builder();
        $builder->distinct();
        $builder->select('currency_code');
        $queryResults = $builder->get()->getResult();
        $response = [];
        foreach ($queryResults as $row) {
            $response[] = $row->currency_code;
        }
        return $response;
    }

    /**
     * @return array|bool
     */
    public function getAllDates(): array|bool
    {
        try {
            $currencyRate = $this->findAll();
            if (!$currencyRate) {
                // Fetch the data from the API
                $currencyApi = new CurrencyApi();
                $ratesWithDate = $currencyApi->getHistoricalDataForACodeFromAPI(null, '2021-01-01', date('Y-m-d'));
                //Save data in database
                foreach ($ratesWithDate as $date => $rates) {
                    $this->saveData($date, $rates);
                }
            }
            return $this->findAll();
        } catch (Exception $e) {
            // Log the error message
            log_message('error', $e->getMessage());
            return false;
        }
    }

    /**
     * @param string $date
     * 
     * @return array|bool
     */
    public function getOneDate(string $date): array|bool
    {
        try {
            // Fetch the data from the database
            $currencyRates = $this->where(['date' => $date])->get()->getResultArray();

            if (!$currencyRates) {
                // Fetch the data from the API
                $currencyApi = new CurrencyApi();
                $rates = $currencyApi->getHistoricalDataForACodeFromAPI(null, $date);
                //Save data in database
                $this->saveData($date, $rates);
            }
            return $this->where(['date' => $date])->get()->getResultArray();
        } catch (Exception $e) {
            // Log the error message
            log_message('error', $e->getMessage());
            return false;
        }
    }

    /**
     * @param string $currencyCode
     * 
     * @return array|bool
     */
    public function getOneCurrency(string $currencyCode): array|bool
    {
        try {
            // Fetch the data from the database
            $currencyRate = $this->where(['currency_code' => $currencyCode])->get()->getResultArray();

            if (!$currencyRate) {
                // Fetch the data from the API
                $currencyApi = new CurrencyApi();
                $ratesWithDate = $currencyApi->getHistoricalDataForACodeFromAPI($currencyCode, '2021-01-01', date('Y-m-d'));
                //Save data in database
                foreach ($ratesWithDate as $date => $rates) {
                    $this->saveData($date, $rates);
                }
            }
            return $this->where(['currency_code' => $currencyCode])->get()->getResultArray();
        } catch (Exception $e) {
            // Log the error message
            log_message('error', $e->getMessage());
            return false;
        }
    }

    /**
     * @param string $currencyCode
     * @param string $date
     * 
     * @return array|bool
     */
    public function getOneCurrencyOneDate(string $currencyCode, string $date): array|bool
    {
        try {
            // Fetch the data from the database
            $currencyRate = $this->where(['currency_code' => $currencyCode, 'date' => $date])->get()->getResultArray();

            if (!$currencyRate) {
                // Fetch the data from the API
                $currencyApi = new CurrencyApi();
                $rates = $currencyApi->getHistoricalDataForACodeFromAPI($currencyCode, $date);
                //Save data in database
                $this->saveData($date, $rates);
            }

            return $this->where(['currency_code' => $currencyCode, 'date' => $date])->get()->getResultArray();
        } catch (Exception $e) {
            // Log the error message
            log_message('error', $e->getMessage());
            return false;
        }
    }

    /**
     * @param string|null $date
     * @param array $rates
     * 
     * @return bool
     */
    private function saveData(string $date = null, array $rates): bool
    {
        try {
            $insertArr = [];
            foreach ($rates as $code => $rate) {
                $newObj['date'] = $date;
                $newObj['currency_code'] = $code;
                $newObj['rate'] = $rate;
                $insertArr[] = $newObj;
            }
            // Save the data to the database
            $this->insertBatch($insertArr);
            return true;
        } catch (Exception $e) {
            // Log the error message
            log_message('error', $e->getMessage());
            throw $e;
        }
    }
}
