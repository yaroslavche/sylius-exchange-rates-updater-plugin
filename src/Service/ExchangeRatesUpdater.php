<?php

declare(strict_types=1);

namespace Acme\SyliusExchangeRatesUpdaterPlugin\Service;

use Sylius\Component\Currency\Model\ExchangeRate;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ExchangeRatesUpdater implements ContainerAwareInterface
{
    use \Symfony\Component\DependencyInjection\ContainerAwareTrait;

    private $entityManager;
    private $currencyRepository;
    private $exchangeRateRepository;

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        $this->entityManager = $this->container->get('doctrine')->getEntityManager();
        $this->currencyRepository = $this->container->get('sylius.repository.currency');
        $this->exchangeRateRepository = $this->container->get('sylius.repository.exchange_rate');
    }


    public function generateExchangeRates() : void
    {
        $availableCurrencies = $this->currencyRepository->findAll();
        if (count($availableCurrencies) < 2) {
            return;
        }
        $currenciesTemp = $availableCurrencies;
        $currenciesCount = count($availableCurrencies);
        $pairs = [];
        foreach ($availableCurrencies as $currency) {
            $index = 0;
            while ($index < $currenciesCount - 1) {
                $pairs[] = [$currenciesTemp[0], $currenciesTemp[$index + 1]];
                $index++;
            }
            $currenciesCount--;
            array_shift($currenciesTemp);
        }
        foreach ($pairs as [$sourceCurrency, $targetCurrency])
        {
            $exchangeRate = $this->exchangeRateRepository->findOneWithCurrencyPair($sourceCurrency->getCode(), $targetCurrency->getCode());
            if(null === $exchangeRate) {
                $exchangeRate = new ExchangeRate();
                $exchangeRate->setSourceCurrency($sourceCurrency);
                $exchangeRate->setTargetCurrency($targetCurrency);
                $exchangeRate->setRatio(0);
                $this->entityManager->persist($exchangeRate);
            }
        }
        $entityManager->flush();
    }

    /**
     * @param $exchangeRateLoader ExchangeRateLoaderInterface
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(ExchangeRateLoaderInterface $exchangeRateLoader) : void
    {
        $exchangeRates = $this->exchangeRateRepository->findAll();
        /**
         * @var $exchangeRate ExchangeRate
         */
        foreach($exchangeRates as $exchangeRate){
            $ratio = $exchangeRateLoader->getExchangeRate($exchangeRate->getSourceCurrency()->getCode(), $exchangeRate->getTargetCurrency()->getCode());
            $exchangeRate->setRatio($ratio);
        }
        $this->entityManager->flush();
    }
}
