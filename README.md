# Provides connection to Webronics SEO Tags Platform API

## Install

``` sh
$ composer require qortex/php-webtronics-connector
```

## Use

First, obtain API key for WebtronicsConnector

Then, pass API key to `WebtronicsConnector` constructor:
``` php
use Qortex\Webtronics\Services\Connector as WebtronicsConnector;

$webtronicsConnector = new WebtronicsConnector($apiKey);
```
Last, use any of the following `WebtronicsConnector` methods to communicate with Webtronics SEO Platform:

``` php
function queryUrlTags(string $url)
```
Queries all tags for `$url` in a json array.
