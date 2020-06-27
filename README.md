NewRelic module for Zend Framework
==================================

NewRelic module provide an object-oriented PHP wrapper for [New Relic](http://newrelic.com/) monitoring service.

[![Build Status](https://img.shields.io/travis/neeckeloo/NewRelic.svg?style=flat)](http://travis-ci.org/neeckeloo/NewRelic)
[![Latest Stable Version](http://img.shields.io/packagist/v/neeckeloo/NewRelic.svg?style=flat)](https://packagist.org/packages/neeckeloo/NewRelic)
[![Total Downloads](http://img.shields.io/packagist/dt/neeckeloo/NewRelic.svg?style=flat)](https://packagist.org/packages/neeckeloo/newrelic)
[![Coverage Status](http://img.shields.io/coveralls/neeckeloo/NewRelic.svg?style=flat)](https://coveralls.io/r/neeckeloo/NewRelic)
[![Scrutinizer Quality Score](http://img.shields.io/scrutinizer/g/neeckeloo/NewRelic.svg?style=flat)](https://scrutinizer-ci.com/g/neeckeloo/NewRelic/)

Introduction
------------

NewRelic module provide a logger and a wrapper for [New Relic PHP API](https://newrelic.com/docs/php/the-php-api).

The current route is used to set the name of each transaction. Moreover, the module allow exceptions logging if enabled.

Requirements
------------

* PHP ^7.2
* Zend Framework

Installation
------------

NewRelic module only officially supports installation through Composer. For Composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

You can install the module from command line:
```sh
$ php composer.phar require neeckeloo/newrelic:~1.2
```

Alternatively, you can also add manually the dependency in your `composer.json` file:
```json
{
    "require": {
        "neeckeloo/newrelic": "~1.2"
    }
}
```

Enable the module by adding `NewRelic` key to your `application.config.php` file. Customize the module by copy-pasting
the `newrelic.global.php.dist` file to your `config/autoload` folder.

Default configuration
---------------------

```php
return [
    'newrelic' => [
        // Sets the newrelic app name.  Note that this will discard metrics
        // collected before the name is set.  If empty then your php.ini
        // configuration will take precedence. You can set the value by
        // environment variable, or by overriding in a local config.
        'application_name' => getenv('NEW_RELIC_APP_NAME') ?: null,

        // May be null and will only be set if application name is also given.
        // You can set the value by environment variable, or by overriding in 
        // a local config.
        'license' => getenv('NEW_RELIC_LICENSE_KEY ') ?: null,

        // If false then neither change the auto_instrument or manually
        // instrument the real user monitoring.
        'browser_timing_enabled' => false,

        // When true tell the newrelic extension to insert Real User Monitoring
        // scripts automatically.
        'browser_timing_auto_instrument' => true,

        // When true, a logger with the newrelic writer will be called for
        // dispatch error events.
        'exceptions_logging_enabled' => false,

        // Defines ignored transactions
        'ignored_transactions' => [],

        // Defines background job transactions
        'background_jobs' => [],
    ],
];
```

Usage
-----

### Define transaction name

The module use `NewRelic\Listener\RequestListener` to specify the transaction name automatically using matched route name by default.

#### Transaction name providers

The transaction name is retrieved from a provider (`NewRelic\TransactionNameProvider\RouteNameProvider` by default) defined in the configuration.

```php
use NewRelic\TransactionNameProvider\RouteNameProvider;

return [
    'newrelic' => [
        'transaction_name_provider' => RouteNameProvider::class,
    ],
];
```

The package contains some providers:

- RouteNameProvider
- HttpRequestUrlProvider
- NullProvider

#### Specify transaction name manually

You can also defined the transaction name yourself by defining `NullProvider` as transaction name provider and using `nameTransaction` method of the client.

### Ignore transactions

NewRelic API allows to ignore some transactions. This configuration defines some routes and controllers of transactions that will be ignored.

#### Ignore routes

```php
return [
    'newrelic' => [
        'ignored_transactions' => [
            'routes' => [
                'admin*',
                'user/login',
            ],
        ],
    ],
];
```

Those rules ignore all admin routes and the "user/login" route.

#### Ignore controllers

```php
return [
    'newrelic' => [
        'ignored_transactions' => [
            'controllers' => [
                'FooController',
                'BarController',
                'BazController',
            ],
        ],
    ],
];
```

You can also ignore some actions of specified controllers :

```php
return [
    'newrelic' => [
        'ignored_transactions' => [
            'controllers' => [
                ['FooController', ['foo', 'bar']],
                ['BarController', ['baz']],
            ],
        ],
    ],
];
```

#### Ignore a transaction manually

You can ignore a transaction manually by calling ```ignoreTransaction()``` method of NewRelic client.

```php
$client = $container->get('NewRelic\Client');
$client->ignoreTransaction();
```

### Define background jobs

The configuration of background jobs is identical to ignored transactions but use the key ```background_jobs``` as below.

```php
return [
    'newrelic' => [
        'background_jobs' => [],
    ],
];
```

#### Define a background job manually

You can define a transaction as background job manually by calling ```backgroundJob()``` method of NewRelic client.

```php
$client = $container->get('NewRelic\Client');
$client->backgroundJob(true);
```

### Ignore apdex metrics

You can ignore apdex metrics like transaction metrics using the key ```ignored_apdex```.

```php
return [
    'newrelic' => [
        'ignored_apdex' => [],
    ],
];
```

#### Ignore apdex metrics manually

You can ignore apdex metrics manually by calling ```ignoreApdex()``` method of NewRelic client.

```php
$client = $container->get('NewRelic\Client');
$client->ignoreApdex();
```

### Add custom metric

```php
$client = $container->get('NewRelic\Client');
$client->addCustomMetric('salesprice', $price);
```
