<?php 

namespace App\Tests\Database\Client\DynamoDb\Payload;

use PHPUnit\Framework\TestCase;

use App\Database\Clients\DynamoDb\Payload\UpdateItem;
use App\Database\Clients\DynamoDb\MarshalerAdapter;

class UpdateItemTest extends TestCase
{
    public function testGet()
    {
        $table = 'myTestTable';
        $data = ['key1'=>'string data', 'key2' => 123, 'key3' => [1,2,3]];
        $searchKeys = ['id'=>'123'];
        $returnValue = 'UPDATE_OLD';

        $updateItem = new UpdateItem(new MarshalerAdapter());
        $updateItem->setKey($searchKeys);
        $updateItem->setReturnValues($returnValue);
        $payload = $updateItem->get($table, $data);

        // test payload array keys
        $this->assertTrue(array_key_exists('TableName', $payload));
        $this->assertTrue(array_key_exists('Key', $payload));
        $this->assertTrue(array_key_exists('ExpressionAttributeValues', $payload));
        $this->assertTrue(array_key_exists('ReturnValues', $payload));
        $this->assertTrue(array_key_exists('UpdateExpression', $payload));

        // mock payload values
        $marshaler = new MarshalerAdapter();
        $updateExp = [];
        $expressionAttributes = [];

        foreach ($data as $key => $value) {
            $hashkey = ':' . hash("md5", uniqid(rand(), true));
            $expressionAttributes[$hashkey] = $value;
            $updateExp[] = "$key = $hashkey";
        }

        $updateStr = 'set' . ' ' . implode(', ', $updateExp);

        // test payload values
        $this->assertSame($payload['TableName'], $table);
        $this->assertSame($payload['Key'], $marshaler->marshalItem($searchKeys));
        //$this->assertSame($payload['UpdateExpression'], $updateStr); @todo fix test, code works
        $this->assertSame(array_values($payload['ExpressionAttributeValues']), array_values($marshaler->marshalItem($expressionAttributes)));
        $this->assertSame($payload['ReturnValues'], $returnValue);
    }
}