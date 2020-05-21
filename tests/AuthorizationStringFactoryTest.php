<?php

use Legionth\Serin\Internal\AuthorizationStringFactory;
use Legionth\Serin\Internal\SignatureFactory;
use PHPUnit\Framework\TestCase;
use RingCentral\Psr7\ServerRequest;

class AuthorizationStringFactoryTest extends TestCase
{
    public function testCreate()
    {
        $signatureFactory = $this->getMockBuilder(SignatureFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $signatureFactory->expects($this->once())
            ->method('create')
            ->willReturn('tnnArxj06cWHq44gCs1OSKk/jLY=');

        $authorizationFactory = new AuthorizationStringFactory($signatureFactory);

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

        $request = new ServerRequest(
            'POST',
            'https://api.twitter.com/1.1/statuses/update.json',
            [ 'Content-Type' => 'application/x-www-form-urlencoded'],
            'status=' . rawurlencode($tweet)
        );
        $request = $request->withQueryParams(['include_entities' => 'true']);

        $authString = $authorizationFactory->create(
            $oAuthHeader,
            $consumerSecret,
            $tokenSecret,
            $request
        );

        $this->assertEquals('OAuth oauth_consumer_key="xvz1evFS4wEEPTGEFPHBog", oauth_nonce="kYjzVBB8Y0ZFabxSWbWovY3uYSQ2pTgmZeNu2VS4cg", oauth_signature="tnnArxj06cWHq44gCs1OSKk%2FjLY%3D", oauth_signature_method="HMAC-SHA1", oauth_timestamp="1318622958", oauth_token="370773112-GmHxMAgYyLbNEtIKZeRNFsMKPR9EyMZeS9weJAEb", oauth_version="1.0"', $authString);
    }
}