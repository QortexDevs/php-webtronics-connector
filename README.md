# Provides connection to Webronics SEO Tags Platform API

## Install

``` sh
$ composer require qortex/php-webtronics-connector
```

## Use

First, obtain credentials for [Emarsys API User](https://help.emarsys.com/hc/en-us/articles/115004740329-your-account-security-settings#api-users).

Then, pass these credentials as username and secret to `EmarsysConnector` constructor:
``` php
use Qortex\Webtronics\Services\Connector as WebtronicsConnector;

$webtronicsConnector = new WebtronicsConnector($apiKey);
```
Last, use any of the following `WebtronicsConnector` methods to communicate with Webtronics SEO Platform:

``` php
function queryUrlTags(string $url)
```
Queries all tags for `$url` in a json array.
