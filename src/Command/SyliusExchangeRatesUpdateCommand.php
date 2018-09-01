<?php

namespace Acme\SyliusExchangeRatesUpdaterPlugin\Command;

use Acme\SyliusExchangeRatesUpdaterPlugin\Service\ExchangeRatesUpdater;

use Acme\SyliusExchangeRatesUpdaterPlugin\Service\FixerLoader;
use Acme\SyliusExchangeRatesUpdaterPlugin\Service\OpenExchangeRatesLoader;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SyliusExchangeRatesUpdateCommand extends ContainerAwareCommand
{
    protected static $defaultName = 'sylius:exchange-rates:update';

    protected function configure()
    {
        $this
            ->setDescription('Update exchange rates')
            // bin/console s:e:u -> update all
            // bin/console s:e:u USD_EUR UAH_EUR -> update only USD_EUR UAH_EUR if exists
            // bin/console s:e:u --all USD_EUR UAH_EUR -> update all exclude USD_EUR UAH_EUR
            // ??? or --include and --exclude options arrays
            ->addArgument('pairs', InputArgument::OPTIONAL | InputArgument::IS_ARRAY, 'Exchange rates pairs, e.g. USD_UAH, if --all option enabled these pairs will be excluded')
            ->addOption('all', true, InputOption::VALUE_NONE, 'Update all exchange rates. Default: true')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $pairs = $input->getArgument('pairs');

        if (count($pairs) > 0) {
            $io->note(sprintf('You passed an argument: %s', implode(', ', $pairs)));
        }

        if ($input->getOption('all')) {
            $io->note('You passed an option: all');
        }

        $exchangeRatesUpdaterService = new ExchangeRatesUpdater($this->getContainer());
//        $exchangeRateLoader = new FixerLoader();
        $exchangeRateLoader = new OpenExchangeRatesLoader();
        $exchangeRatesUpdaterService->update($exchangeRateLoader);


        $io->success('Updated!');
    }
}
