<?php

namespace Acme\SyliusExchangeRatesUpdaterPlugin\Service;

use GuzzleHttp\Client;

class FixerLoader extends ExchangeRateLoaderInterface
{

    public function getExchangeRate(string $sourceCurrencyCode, string $targetCurrencyCode) : float
    {
        $client = new Client([
            'base_uri' => 'http://data.fixer.io/api/',
            'timeout'  => 5.0,
        ]);
        // todo: remove this
        require_once '../../api_keys.php';
        $response = $client->get('latest', ['query' => ['access_key' => , 'symbols' => sprintf('%s,%s', $sourceCurrencyCode, $targetCurrencyCode)]]);
        $result = json_decode($response->getBody()->getContents());
        if(isset($result->rates))
        {
            return $result->rates->$targetCurrencyCode / $result->rates->$sourceCurrency;
        }
        return 0;
    }


}
