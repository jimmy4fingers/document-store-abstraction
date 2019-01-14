<?php 

namespace App\Tests\AWS\Factories;

use Aws\Result;
use Aws\MockHandler;
use Aws\DynamoDb\DynamoDbClient;
use Aws\CommandInterface;
use Psr\Http\Message\RequestInterface;
use Aws\Exception\AwsException;

class DynamoDbFactory
{
    public function make(array $result)
    {
        $mock = new MockHandler();

        // Return a mocked result
        $mock->append(new Result(['foo' => 'bar']));

        return new DynamoDbClient([
            'region'  => 'us-west-2',
            'version' => 'latest',
            'handler' => $mock
        ]);
    }
}