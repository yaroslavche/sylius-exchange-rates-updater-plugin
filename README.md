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

### Usage
For daily update add folowwing to crontab:
```
0 0 * * * /path_to_sylius/bin/console sylius:exchange-rates:update
```
