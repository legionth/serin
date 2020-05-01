<?php


use Clue\React\Buzz\Browser;
use Legionth\Serin\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testTweet()
    {
        $loop = \React\EventLoop\Factory::create();

        $oauthConsumerKey = '<consumer-key>';
        $consumerSecret = '<consumer-secret>';

        $oauthToken = '<oauth-token>';
        $tokenSecret = '<token-secret>';

        /** @var Browser $mock */
        $mock = $this->getMockBuilder(Browser::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('send')
            ->willReturn(new \React\Promise\Promise(
                function(callable $resolve, callable $reject) {
                    $resolve(new \RingCentral\Psr7\Response());
                })
            );

        $client = new \Legionth\Serin\Client(
            $loop,
            $oauthConsumerKey,
            $consumerSecret,
            $oauthToken,
            $tokenSecret,
            $mock
        );

        $response = $client->tweet('This is a test');

        $result = 0;
        $response->then(function (\Psr\Http\Message\ResponseInterface $response) use (&$result) {
            $result = $response->getStatusCode();
        }, function (Exception $exception) {
            $this->fail($exception->getMessage());
        });
        $this->assertEquals(200, $result);

    }
}
