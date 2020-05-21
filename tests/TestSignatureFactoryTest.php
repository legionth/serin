<?php


use Legionth\Serin\Internal\AuthorizationStringFactory;
use RingCentral\Psr7\ServerRequest;

class TestSignatureFactoryTest extends TestCase
{
    public function testSignature()
    {
        $oauthConsumerKey = 'xvz1evFS4wEEPTGEFPHBog';
        $consumerSecret = 'kAcSOqF21Fu85e7zjz7ZN2U4ZRhfV3WpwPAoE3Z7kBw';

        $oauthToken = '370773112-GmHxMAgYyLbNEtIKZeRNFsMKPR9EyMZeS9weJAEb';
        $tokenSecret = 'LswwdoUaIvS8ltyTt5jkRh4J50vUPVVHtR2YPi5kE';

        $oAuthHeader = [
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $oauthToken,
            'oauth_consumer_key' => $oauthConsumerKey,
            'oauth_nonce' => 'kYjzVBB8Y0ZFabxSWbWovY3uYSQ2pTgmZeNu2VS4cg',
            'oauth_timestamp' => '1318622958',
            'oauth_version' => '1.0'
        ];

        $tweet ='Hello Ladies + Gentlemen, a signed OAuth request!';

        $signatureFactory = new \Legionth\Serin\Internal\SignatureFactory();

        $request = new ServerRequest(
            'POST',
            'https://api.twitter.com/1.1/statuses/update.json',
            [ 'Content-Type' => 'application/x-www-form-urlencoded'],
            'status=' . rawurlencode($tweet)
        );

        $request = $request->withQueryParams(['include_entities' => 'true']);
        $signature = $signatureFactory->create($consumerSecret, $tokenSecret, $oAuthHeader, $request);

        $this->assertEquals('hCtSmYh+iHYCEqBWrE7C7hYmtUk=', $signature);
    }
}