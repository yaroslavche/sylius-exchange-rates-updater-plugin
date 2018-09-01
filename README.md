## Generate exchange rates

```
bin/console sylius:exchange-rates:generate
```
This command generate all available unique currency pairs from Sylius available currencies.

## Update exchange rates

```
bin/console sylius:exchange-rates:update
```
This command try to update all existing exchange rates in Sylius.

## Install
```
composer require yaroslavche/sylius-exchange-rates-updater-plugin
```

Register plugin
```php
# app/AppKernel.php

# ...
public function registerBundles(): array
{
    $bundles = [
        # ...
        new \Acme\SyliusExchangeRatesUpdaterPlugin\AcmeSyliusExchangeRatesUpdaterPlugin(),
    ];
    #...
}
```

Import service config
```yml
#app/config/config.yml

imports:
    # ...
    - { resource: '@AcmeSyliusExchangeRatesUpdaterPlugin/Resources/config/services.yml' }
    # ...
```

And add params:
```yml
#app/config/parameters.yml
parameters:
    # ...
    
    exchange_rates_updater_plugin.openexchangerates: 'your_api_key'
    exchange_rates_updater_plugin.fixer: 'your_api_key' # not used now
```

### Usage
For daily update add following to crontab:
```
0 0 * * * /path_to_sylius/bin/console sylius:exchange-rates:update
```
