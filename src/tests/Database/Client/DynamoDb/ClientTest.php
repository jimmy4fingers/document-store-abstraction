<?php 

namespace App\Tests\Database\Client\DynamoDb;

use PHPUnit\Framework\TestCase;
use App\Database\Client\DynamoDb\Client;
use App\Database\Client\DynamoDb\MarshalerFactory;
use App\Database\Client\DocumentStoreClient;
use App\Tests\AWS\Factories\DynamoDbFactory;

class ClientTest extends TestCase
{
    private $clientFactory;

    public function setUp()
    {
        $this->clientFactory = new DynamoDbFactory();
    }

    public function testConstructor()
    {
        $dynamoDbClient = $this->clientFactory->make(['test']);
        $client = new Client($dynamoDbClient, new MarshalerFactory());

        $reflector = new \ReflectionClass($client);
		$property = $reflector->getProperty('dynamo');
        $property->setAccessible(true);
        
        // test correct object set on private property
        $this->assertSame($dynamoDbClient, $property->getValue($client));
        // test implements correct interface
        $this->assertTrue($reflector->implementsInterface('App\Database\Client\DocumentStoreClient'));
    }

    public function testCreate()
    {
        $dynamoDbClient = $this->clientFactory->make(['test']);
        $client = new Client($dynamoDbClient, new MarshalerFactory());

        $payload = ['test'=>'data'];

        // table name, item attributes\values
        $this->assertTrue($client->create('myTestTable', $payload));
    }

    public function _testUpdate()
    {
        // test func exsits
        // @todo
    }

}