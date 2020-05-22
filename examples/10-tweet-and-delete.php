<?php

use React\EventLoop\Factory;

require_once __DIR__ . '/../vendor/autoload.php';

$loop = Factory::create();

$oauthConsumerKey = 'replace-with-consumer-key';
$consumerSecret = 'replace-with-consumer-secret';

$oauthToken = 'replace-with-oauth-token';
$tokenSecret = 'replace-with-token-secret';

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
    $content = (string) $response->getBody();

    $jsonDecoded = json_decode($content, true);
    $result = $client->delete((int) $jsonDecoded['id']);

    $result->then(function (\Psr\Http\Message\ResponseInterface $response) use ($client) {
        echo \RingCentral\Psr7\str($response);
    }, function (Exception $exception) {
        echo(\RingCentral\Psr7\str($exception->getResponse()));
    });
}, function (Exception $exception) {
    echo(\RingCentral\Psr7\str($exception->getResponse()));
});

$loop->run();