<?php

namespace App\Controllers;

use App\Models\CurrencyRateModel;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use App\Helpers\CurrencyHelper;
use CodeIgniter\Config\Services;

class CurrencyRate extends BaseController
{
    protected $currencyRateModel;

    public function __construct()
    {
        $this->currencyRateModel = new CurrencyRateModel();
        $this->response = Services::response();
    }

    /**
     * Get all the currencies
     * @return Response
     */
    public function index()
    {
        return $this->getResponse(
            [
                'message' => 'All currencies retrieved successfully',
                'currencies' => $this->currencyRateModel->getAllCurrencies()
            ]
        );
    }

    /**
     * Get all currency rate for all available dates
     * @return Response
     */
    public function getCurrencyRateAllDates()
    {
        $currencyRates = $this->currencyRateModel->getAllDates();

        if (!$currencyRates || count($currencyRates) < 1) {
            return $this->getResponse(
                [
                    'message' => 'No rates found.'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }

        return $this->getResponse(
            [
                'message' => 'Currency rates for all available dates retrieved successfully',
                'currencyRates' => CurrencyHelper::getCurrencyResponse($currencyRates)
            ]
        );
    }

    /**
     * Get all currency rate for particular date
     * @param string $date
     * @return Response
     */
    public function getCurrencyRateOneDate(string $date)
    {
        $currencyRates = $this->currencyRateModel->getOneDate($date);

        if (!$currencyRates || count($currencyRates) < 1) {
            return $this->getResponse(
                [
                    'message' => 'No rates found.'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }

        return $this->getResponse(
            [
                'message' => 'Currency rates for all available dates retrieved successfully',
                'currencyRates' => CurrencyHelper::getCurrencyResponse($currencyRates)
            ]
        );
    }

    /**
     * Get currency rate for a specific currency code
     * @param string $currencyCode
     * @return Response
     */
    public function getCurrencyRateByCode(string $currencyCode)
    {
        $currencyRates = $this->currencyRateModel->getOneCurrency($currencyCode);

        if (!$currencyRates) {
            return $this->getResponse(
                [
                    'message' => 'No rates found for ' . $currencyCode
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }

        return $this->getResponse(
            [
                'message' => 'Currency rate for ' . $currencyCode . ' retrieved successfully',
                'currencyRate' => CurrencyHelper::getCurrencyResponse($currencyRates)
            ]
        );
    }

    /**
     * Get currency rate for a specific currency code and date
     * @param string $currencyCode
     * @param string $date
     * @return Response
     */
    public function getCurrencyRateByCodeAndDate(string $currencyCode, string $date)
    {
        $currencyRates = $this->currencyRateModel->getOneCurrencyOneDate($currencyCode, $date);

        if (!$currencyRates) {
            return $this->getResponse(
                [
                    'message' => 'No rates found for ' . $currencyCode . ' on ' . $date,
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }

        return $this->getResponse(
            [
                'message' => 'Currency rate for ' . $currencyCode . ' on ' . $date . ' retrieved successfully',
                'currencyRate' => CurrencyHelper::getCurrencyResponse($currencyRates)
            ]
        );
    }

    /**
     * @param array $responseBody
     * @param int $code
     * 
     * @return Response
     */
    private function getResponse(array $responseBody, int $code = ResponseInterface::HTTP_OK): Response
    {
        return $this->response->setStatusCode($code)->setJSON($responseBody);
    }
}
