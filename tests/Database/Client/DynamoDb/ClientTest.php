<?php 

namespace App\Tests\Database\Client\DynamoDb;

use PHPUnit\Framework\TestCase;
use App\Database\Clients\DynamoDb\Client;
use App\Database\Clients\DynamoDb\MarshalerAdapter;
use App\Database\Clients\DynamoDb\PayloadFactory;
use App\Database\Clients\DynamoDb\ClientHandler;
use App\Database\Clients\DocumentStoreClient;
use App\Tests\Mocks\AWSMocksFactory;

class ClientTest extends TestCase
{
    protected static $awsFactory;

    public static function setUpBeforeClass()
    {
        self::$awsFactory = new AWSMocksFactory();
    }

    public function testConstructor()
    {
        $dynamoDbClient = self::$awsFactory->mockDynamoDbClient(['test']);
        $client = new Client($dynamoDbClient, new PayloadFactory(new MarshalerAdapter()));

        $reflector = new \ReflectionClass($client);
		$property = $reflector->getProperty('dynamoDbClient');
        $property->setAccessible(true);
        
        // test correct object set on private property
        $this->assertSame($dynamoDbClient, $property->getValue($client));
        // test implements correct interface
        $this->assertTrue($reflector->implementsInterface('App\Database\Clients\DocumentStoreClient'));
    }

    public function testCreate()
    {
        $dynamoDbClient = self::$awsFactory->mockDynamoDbClient(['test']);

        $client = new Client($dynamoDbClient, new PayloadFactory(new MarshalerAdapter()));
        $client = new ClientHandler($client);

        $data = ['test'=>'data'];

        // table name, item attributes\values
        $this->assertTrue($client->create('myCreateTestTable', $data));
    }

    public function testUpdate()
    {
        $dynamoDbClient = self::$awsFactory->mockDynamoDbClient(['test']);

        $client = new Client($dynamoDbClient, new PayloadFactory(new MarshalerAdapter()));
        $client = new ClientHandler($client);

        $data = ['test'=>'data'];
        $searchKeys = ['id' => 123];

        // table name, item attributes\values
        $this->assertTrue($client->update('myUpdateTestTable', $searchKeys, $data));
    }

    public function testGet()
    {
        $dynamoDbClient = self::$awsFactory->mockDynamoDbClient(['test']);

        $client = new Client($dynamoDbClient, new PayloadFactory(new MarshalerAdapter()));
        $client = new ClientHandler($client);

        $data = ['test'=>'data'];
        $searchKeys = ['id' => 123];

        // table name, item attributes\values
        $this->assertSame($client->get('myUpdateTestTable', $searchKeys),[]);
    }

}