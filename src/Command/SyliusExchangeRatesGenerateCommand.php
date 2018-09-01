<?php

namespace Acme\SyliusExchangeRatesUpdaterPlugin\Command;

use Acme\SyliusExchangeRatesUpdaterPlugin\Service\ExchangeRatesUpdater;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SyliusExchangeRatesGenerateCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'sylius:exchange-rates:generate';

    protected function configure()
    {
        $this->setDescription('Generate exchange rates');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $exchangeRatesUpdaterService = new ExchangeRatesUpdater($this->getContainer());
        $exchangeRatesUpdaterService->generateExchangeRates();
        $io->success('Generated!');
    }
}
