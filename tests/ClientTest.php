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
            ->with($this->callback(function (\Psr\Http\Message\RequestInterface $request) {
                $this->assertStringContainsString('https://api.twitter.com/1.1/statuses/update.json', (string)$request->getUri());
                return true;
            }))
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

    public function testDelete()
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
            ->with($this->callback(function (\Psr\Http\Message\RequestInterface $request) {
                $this->assertStringContainsString('https://api.twitter.com/1.1/statuses/destroy/', (string)$request->getUri());
                return true;
            }))
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

        $response = $client->delete(100);

        $result = 0;
        $response->then(function (\Psr\Http\Message\ResponseInterface $response) use (&$result) {
            $result = $response->getStatusCode();
        }, function (Exception $exception) {
            $this->fail($exception->getMessage());
        });
        $this->assertEquals(200, $result);
    }

    public function testShow()
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
            ->with($this->callback(function (\Psr\Http\Message\RequestInterface $request) {
                $this->assertStringContainsString('https://api.twitter.com/1.1/statuses/show/', (string)$request->getUri());
                return true;
            }))
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

        $response = $client->show(200);

        $result = 0;
        $response->then(function (\Psr\Http\Message\ResponseInterface $response) use (&$result) {
            $result = $response->getStatusCode();
        }, function (Exception $exception) {
            $this->fail($exception->getMessage());
        });
        $this->assertEquals(200, $result);
    }

    public function testRetweet()
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
            ->with($this->callback(function (\Psr\Http\Message\RequestInterface $request) {
                $this->assertStringContainsString('https://api.twitter.com/1.1/statuses/retweet/', (string)$request->getUri());
                return true;
            }))
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

        $response = $client->retweet(200);

        $result = 0;
        $response->then(function (\Psr\Http\Message\ResponseInterface $response) use (&$result) {
            $result = $response->getStatusCode();
        }, function (Exception $exception) {
            $this->fail($exception->getMessage());
        });
        $this->assertEquals(200, $result);
    }

    public function testUnretweet()
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
            ->with($this->callback(function (\Psr\Http\Message\RequestInterface $request) {
                $this->assertStringContainsString('https://api.twitter.com/1.1/statuses/unretweet/', (string)$request->getUri());
                return true;
            }))
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

        $response = $client->unretweet(200);

        $result = 0;
        $response->then(function (\Psr\Http\Message\ResponseInterface $response) use (&$result) {
            $result = $response->getStatusCode();
        }, function (Exception $exception) {
            $this->fail($exception->getMessage());
        });
        $this->assertEquals(200, $result);
    }

    public function testRetweetsOfMe()
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
            ->with($this->callback(function (\Psr\Http\Message\RequestInterface $request) {
                $this->assertStringContainsString('https://api.twitter.com/1.1/statuses/retweets_of_me.json', (string)$request->getUri());
                return true;
            }))
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

        $response = $client->retweetsOfMe();

        $result = 0;
        $response->then(function (\Psr\Http\Message\ResponseInterface $response) use (&$result) {
            $result = $response->getStatusCode();
        }, function (Exception $exception) {
            $this->fail($exception->getMessage());
        });
        $this->assertEquals(200, $result);
    }

    public function testRetweets()
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
            ->with($this->callback(function (\Psr\Http\Message\RequestInterface $request) {
                $this->assertStringContainsString('https://api.twitter.com/1.1/statuses/retweets/', (string)$request->getUri());
                return true;
            }))
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

        $response = $client->retweets(200);

        $result = 0;
        $response->then(function (\Psr\Http\Message\ResponseInterface $response) use (&$result) {
            $result = $response->getStatusCode();
        }, function (Exception $exception) {
            $this->fail($exception->getMessage());
        });
        $this->assertEquals(200, $result);
    }


    public function testFavoritesList()
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
            ->with($this->callback(function (\Psr\Http\Message\RequestInterface $request) {
                $this->assertStringContainsString('https://api.twitter.com/1.1/favorites/list.json', (string)$request->getUri());
                return true;
            }))
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

        $response = $client->favoritesList();

        $result = 0;
        $response->then(function (\Psr\Http\Message\ResponseInterface $response) use (&$result) {
            $result = $response->getStatusCode();
        }, function (Exception $exception) {
            $this->fail($exception->getMessage());
        });
        $this->assertEquals(200, $result);
    }



}
