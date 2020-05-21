<?php


namespace Legionth\Serin;


use Clue\React\Buzz\Browser;
use Legionth\Serin\Internal\AuthorizationStringFactory;
use Legionth\Serin\Internal\SignatureFactory;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;
use RingCentral\Psr7\ServerRequest;

class Client
{
    private string $oauthConsumerKey;
    private string $consumerSecret;
    private string $oauthToken;
    private string $tokenSecret;

    /**
     * @var LoopInterface
     */
    private LoopInterface $loop;

    /**
     * @var Browser
     */
    private Browser $client;

    /**
     * @var SignatureFactory
     */
    private SignatureFactory $signatureFactory;
    /**
     * @var AuthorizationStringFactory|null
     */
    private ?AuthorizationStringFactory $authorizationStringFactory;

    public function __construct(
        LoopInterface $loop,
        string $oauthConsumerKey,
        string $consumerSecret,
        string $oauthToken,
        string$tokenSecret,
        Browser $client = null,
        SignatureFactory $signatureFactory = null,
        AuthorizationStringFactory $authorizationStringFactory = null
    ) {
        $this->loop = $loop;
        $this->oauthConsumerKey = $oauthConsumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->oauthToken = $oauthToken;
        $this->tokenSecret = $tokenSecret;

        if (null === $client) {
            $client = new Browser($this->loop);
        }
        $this->client = $client;

        if (null === $signatureFactory) {
            $signatureFactory = new SignatureFactory();
        }
        $this->signatureFactory = $signatureFactory;

        if (null === $authorizationStringFactory) {
            $authorizationStringFactory = new AuthorizationStringFactory($signatureFactory);
        }
        $this->authorizationStringFactory = $authorizationStringFactory;
    }

    public function tweet(string $tweet) : PromiseInterface
    {
        $request = new ServerRequest(
            'POST',
            'https://api.twitter.com/1.1/statuses/update.json',
            [ 'Content-Type' => 'application/x-www-form-urlencoded'],
            'status=' . rawurlencode($tweet),
        );

        $result = $this->send($request);

        return $result;
    }

    public function delete(int $id)
    {
        $request = new ServerRequest(
            'POST',
            'https://api.twitter.com/1.1/statuses/destroy/' . rawurlencode($id) . '.json'
        );

        $result = $this->send($request);

        return $result;
    }

    public function show(int $id) : PromiseInterface
    {
        $request = new ServerRequest(
            'GET',
            'https://api.twitter.com/1.1/statuses/show/' . rawurldecode($id) . '.json'
        );

        $result = $this->send($request);

        return $result;
    }

    public function retweet(int $id)
    {
        $request = new ServerRequest(
            'POST',
            'https://api.twitter.com/1.1/statuses/retweet/' . rawurldecode($id) . '.json'
        );

        $result = $this->send($request);

        return $result;
    }

    public function unretweet(int $id)
    {
        $request = new ServerRequest(
            'POST',
            'https://api.twitter.com/1.1/statuses/unretweet/' . rawurldecode($id) . '.json'
        );

        $result = $this->send($request);

        return $result;
    }

    public function retweetsOfMe()
    {
        $request = new ServerRequest(
            'GET',
            'https://api.twitter.com/1.1/statuses/retweets_of_me.json'
        );

        $result = $this->send($request);

        return $result;
    }

    public function retweets($id)
    {
        $request = new ServerRequest(
            'GET',
            'https://api.twitter.com/1.1/statuses/retweets/' . rawurldecode($id) . '.json'
        );

        $result = $this->send($request);

        return $result;
    }

    public function favoritesList()
    {
        $request = new ServerRequest(
            'GET',
            'https://api.twitter.com/1.1/favorites/list.json'
        );

        $result = $this->send($request);

        return $result;
    }

    public function send(ServerRequestInterface $request) : PromiseInterface
    {
        $oAuthHeader = $this->createOAuthHeader();

        $dst = $this->authorizationStringFactory->create(
            $oAuthHeader,
            $this->consumerSecret,
            $this->tokenSecret,
            $request
        );

        $request = $request->withHeader('Authorization', $dst);

        $result = $this->client->send($request);

        return $result;
    }

    private function createOAuthHeader() : array
    {
        return [
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $this->oauthToken,
            'oauth_consumer_key' => $this->oauthConsumerKey,
            'oauth_nonce' => time(),
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        ];
    }
}