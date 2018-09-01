<?php

namespace Acme\SyliusExchangeRatesUpdaterPlugin\Service;

use GuzzleHttp\Client;

class OpenExchangeRatesLoader extends ExchangeRateLoaderInterface
{
    private $base;
    private $rates;
    private $appId;

    public function __construct(array $config = [])
    {
        $this->appId = $config['app_id'] ?? '';
        $client = new Client([
            'base_uri' => 'https://openexchangerates.org/api/',
            'timeout'  => 5.0,
        ]);
        $response = $client->get('latest.json', ['query' => ['app_id' => $this->appId]]);
        $result = json_decode($response->getBody()->getContents());
        $this->base = $result->base ?? false;
        if ($this->base) {
            foreach ($result->rates as $currencyCode => $ratio) {
                $this->rates[$currencyCode] = $ratio;
            }
        }
    }

    public function getExchangeRate(string $sourceCurrencyCode, string $targetCurrencyCode) : float
    {
        if (array_key_exists($sourceCurrencyCode, $this->rates) && array_key_exists($targetCurrencyCode, $this->rates)) {
            $oneBase = 1 / $this->rates[$sourceCurrencyCode];
            $toBaseRatio = $this->rates[$targetCurrencyCode] * $oneBase;
            return $toBaseRatio;
        }
        return 0;
    }
}
