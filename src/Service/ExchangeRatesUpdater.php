<?php

declare(strict_types=1);

namespace Acme\SyliusExchangeRatesUpdaterPlugin\Service;

class ExchangeRatesUpdater
{

    public function generateExchangeRates(array $pairs = []) : void
    {
        // collect all currencies
        // for each unique pairs create enchange rate with 0 and update        
    }

    public function update() : void
    {
        // $exchangeRatesPairs = [];
        // foreach($exchangeRatesPairs as $exchangeRatePair)
        // {
        //     $this->updateExchangeRate($exchangeRatePair);
        // }
    }

    public function updateExchangeRate(array $pair = []) : void
    {
        // get rate by interface (?) loader
        // update sylius rate
    }
}
