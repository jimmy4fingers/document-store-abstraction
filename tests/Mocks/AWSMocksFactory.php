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
    public function mockDynamoDbClient(array $result)
    {
        $mock = new MockHandler();

        // Return a mocked result
        $mock->append(new Result($result));

        // You can provide a function to invoke; here we throw a mock exception
        $mock->append(function (CommandInterface $cmd, RequestInterface $req) {
            return new AwsException('Mock exception', $cmd);
        });

        // Create a client with the mock handler
        $client = new DynamoDbClient([
            'region'  => 'us-west-2',
            'version' => 'latest',
            'handler' => $mock
        ]);

        return $client;
    }
}