<?php 

namespace App\Tests\Mocks;

use Aws\Result;
use Aws\MockHandler;
use Aws\DynamoDb\DynamoDbClient;
use Aws\CommandInterface;
use Psr\Http\Message\RequestInterface;
use Aws\Exception\AwsException;

class AWSMocksFactory
{
    public function makeDynamoDbClient(MockHandler $mock)
    {
        return new DynamoDbClient([
            'region'  => 'us-west-2',
            'version' => 'latest',
            'handler' => $mock
        ]);
    }

    public function makeMockHandler()
    {
        return new MockHandler();
    }

    public function makeResult($result)
    {
        return new Result($result);
    }
}