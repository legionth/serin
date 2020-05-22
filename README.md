# Serin

Serin is an asynchronous Twitter API CLient built on top of ReactPHP

**Table of Contents**

* [Quickstart](#quickstart)
* [What is different from other libraries?](#what-is-different-from-other-libraries)
* [How to use this library](#how-to-use-this-library)
  * [Endpoints](#endpoints)
  * [Custom Requests](#custom-requests)
* [Authentication](#authentication)
* [Install](#install)
* [License](#license)


## Quickstart

```php
useReact\EventLoop\Factory;

require_once __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$oauthConsumerKey = 'SyCz6mFj7992Wy9tAcM1zQQci';
$consumerSecret = 'm349wE5VEkS3PM2FdS5eeptxoXz4o6jPHVyS1JVpGCZmYyPMqf';

$oauthToken = '3019738408-5wkZjXGk02TfyjWpMMolQHHdkQ3fr8APdkkTluk';
$tokenSecret = 'bo34Dph9tQGQC7cEk7ZBir5f9Du608FylevCAUwzw33sG';

$client = new \Legionth\Serin\Client(
    $loop,
    $oauthConsumerKey,
    $consumerSecret,
    $oauthToken,
    $tokenSecret
);

$response = $client->tweet('does this work?');

$response->then(function (\Psr\Http\Message\ResponseInterface $response) use ($client) {
    echo \RingCentral\Psr7\str($response);
}, function (Exception $exception) {
    echo(\RingCentral\Psr7\str($exception->getResponse()));
});

$loop->run();
```

The code above will create a tweet on the designated account.

## What is different from other libraries?

While other Twitter API Clients written in PHP use extension like
[Curl](https://www.php.net/manual/de/book.curl.php)
to send HTTP Requests, this library uses 100% pure PHP instead.
The usage of [ReactPHP](https://github.com/reactphp) is used to make
this library entirely asynchronous. 

## How to use this library

The `Client` class is all needed to communicate with Twitter API.
Just enter the Twitter secrets and tokens and use the `Client` to
interact with Twitter.

Never used the Twitter API before?
Use the official [Twitter Developer Guide](https://developer.twitter.com/en)
to create the tokens and secrets needed for this library.

This library uses [ReactPHP](https://github.com/reactphp/)
so the entire library is based on a non-blocking concept.
That's why every Client method will Return a
[Promise](https://github.com/reactphp/promise)
which will result in an
[PSR-7 Response](https://www.php-fig.org/psr/psr-7/#33-psrhttpmessageresponseinterface)
when the server answered the request.
In the meantime other requests can be sent without waiting for previous ones
to be finished (unless you want to :) ).

```php
$response = $client->tweet('does this work?');
$responseSecondTweet = $client->tweet('of course it does');

$response->then(function (\Psr\Http\Message\ResponseInterface $response) use ($client) {
    echo \RingCentral\Psr7\str($response);
}, function (Exception $exception) {
    echo(\RingCentral\Psr7\str($exception->getResponse()));
});

$responseSecondTweet->then(function (\Psr\Http\Message\ResponseInterface $response) use ($client) {
    echo \RingCentral\Psr7\str($response);
}, function (Exception $exception) {
    echo(\RingCentral\Psr7\str($exception->getResponse()));
});
```

### Endpoints

Have a look at the Client methods to get an overview of all possible endpoints.
This library tried to be as near as possible on the actual wording of
the [offical Twitter API](https://developer.twitter.com/en/docs).

### Custom Requests

Is some endpoint missing?
No worries create a PSR-7 request containing all necessary data.

The client will authenticate your request with the required OAuth 1.0a authentication.

```php
$client = new \Legionth\Serin\Client(
    $loop,
    $oauthConsumerKey,
    $consumerSecret,
    $oauthToken,
    $tokenSecret
);

$request = new RingCentral\Psr7\ServerRequest(
    'POST',
    'https://api.twitter.com/1.1/statuses/update.json',
    [ 'Content-Type' => 'application/x-www-form-urlencoded'],
    'status=' . rawurlencode('Hello World'),
);

$response = $client->tweet($request);
```

Do you want to have an endpoint in the library?
Open up a Pull Request or contact me!

## Authentication

The OAuth 1.0a Authentication in this library will be used to send tweets,
retweeting and get status information.
That is why a registration at the Twitter API is required in order to use
this library.

## Install

The recommended way to install this library is
[through Composer](https://getcomposer.org).

[New to Composer?](https://getcomposer.org/doc/00-intro.md)

This will install the latest supported version:

```bash
$ composer require legionth/serin:^0.1.0
```

## License

See [License file](LICENSE)
