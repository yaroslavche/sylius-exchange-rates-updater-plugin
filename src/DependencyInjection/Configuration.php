<?php

declare(strict_types=1);

namespace Acme\SyliusExchangeRatesUpdaterPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('acme_sylius_exchange_rates_updater_plugin');

        return $treeBuilder;
    }
}
