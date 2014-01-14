NewRelic module for ZF2
=======================

NewRelic module provide an object-oriented PHP wrapper for [New Relic](http://newrelic.com/) monitoring service.

[![Build Status](https://secure.travis-ci.org/neeckeloo/NewRelic.png?branch=master)](http://travis-ci.org/neeckeloo/NewRelic)
[![Latest Stable Version](https://poser.pugx.org/neeckeloo/NewRelic/v/stable.png)](https://packagist.org/packages/neeckeloo/NewRelic)
[![Coverage Status](https://coveralls.io/repos/neeckeloo/NewRelic/badge.png)](https://coveralls.io/r/neeckeloo/NewRelic)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/neeckeloo/NewRelic/badges/quality-score.png?s=d8f10c2b5c49a2cebe53b533b7a281368b8ddb07)](https://scrutinizer-ci.com/g/neeckeloo/NewRelic/)
[![Dependencies Status](https://d2xishtp1ojlk0.cloudfront.net/d/6979063)](http://depending.in/neeckeloo/NewRelic)

Introduction
------------

NewRelic module provide a logger and a wrapper for [New Relic PHP API](https://newrelic.com/docs/php/the-php-api).

The current route is used to set the name of each transaction. Moreover, the module allow exceptions logging if enabled.

Default configuration
---------------------

```php
<?php
return array(
    'newrelic' => array(
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
    ),
);
```

Usage
-----

### Ignore a transaction

```php
<?php
$client = $this->getServiceLocator()->get('NewRelic\Client');
$client->ignoreTransaction();
```

### Define if current transaction is a background job

```php
<?php
$client = $this->getServiceLocator()->get('NewRelic\Client');
$client->backgroundJob(true);
```

### Add custom metric

```php
<?php
$client = $this->getServiceLocator()->get('NewRelic\Client');
$client->addCustomMetric('salesprice', $price);
```
