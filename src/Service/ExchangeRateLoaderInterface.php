<?php

namespace Acme\SyliusExchangeRatesUpdaterPlugin\Service;


abstract class ExchangeRateLoaderInterface
{
    abstract public function __construct(array $config);
    abstract public function getExchangeRate(string $sourceCurrencyCode, string $targetCurrencyCode) : float;
}
