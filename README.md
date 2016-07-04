NewRelic module for ZF2
=======================

NewRelic module provide an object-oriented PHP wrapper for [New Relic](http://newrelic.com/) monitoring service.

[![Build Status](https://img.shields.io/travis/neeckeloo/NewRelic.svg?style=flat)](http://travis-ci.org/neeckeloo/NewRelic)
[![Latest Stable Version](http://img.shields.io/packagist/v/neeckeloo/NewRelic.svg?style=flat)](https://packagist.org/packages/neeckeloo/NewRelic)
[![Total Downloads](http://img.shields.io/packagist/dt/neeckeloo/NewRelic.svg?style=flat)](https://packagist.org/packages/neeckeloo/newrelic)
[![Coverage Status](http://img.shields.io/coveralls/neeckeloo/NewRelic.svg?style=flat)](https://coveralls.io/r/neeckeloo/NewRelic)
[![Scrutinizer Quality Score](http://img.shields.io/scrutinizer/g/neeckeloo/NewRelic.svg?style=flat)](https://scrutinizer-ci.com/g/neeckeloo/NewRelic/)
[![Dependencies Status](https://www.versioneye.com/user/projects/519e3304a20a6c000200df0e/badge.svg?style=flat)](https://www.versioneye.com/user/projects/519e3304a20a6c000200df0e)

Introduction
------------

NewRelic module provide a logger and a wrapper for [New Relic PHP API](https://newrelic.com/docs/php/the-php-api).

The current route is used to set the name of each transaction. Moreover, the module allow exceptions logging if enabled.

Requirements
------------

* PHP 5.6 or PHP 7

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
        // configuration will take precedence.
        'application_name' => null,

        // May be null and will only be set if application name is also given.
        'license' => null,

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
$client = $this->getServiceLocator()->get('NewRelic\Client');
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
$client = $this->getServiceLocator()->get('NewRelic\Client');
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
$client = $this->getServiceLocator()->get('NewRelic\Client');
$client->ignoreApdex();
```

### Add custom metric

```php
$client = $this->getServiceLocator()->get('NewRelic\Client');
$client->addCustomMetric('salesprice', $price);
```
