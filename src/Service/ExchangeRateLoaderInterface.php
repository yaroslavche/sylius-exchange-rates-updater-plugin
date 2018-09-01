<?php

namespace Acme\SyliusExchangeRatesUpdaterPlugin\Service;


abstract class ExchangeRateLoaderInterface
{
    abstract public function getExchangeRate(string $sourceCurrencyCode, string $targetCurrencyCode) : float;
}
