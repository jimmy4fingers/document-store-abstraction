<?php

include('vendor/autoload.php');

use App\Database\Client\DynamoDb\Client;
use App\Database\Client\DynamoDb\MarshalerFactory;
use App\Database\Client\DynamoDb\PayloadFactory;
use App\Database\Client\DocumentStoreClient;

$dynamoDbClient = new \Aws\DynamoDb\DynamoDbClient([
    'region'   => 'us-west-2',
    'version'  => 'latest',
    'endpoint' => 'http://localhost:8000',
    'credentials' => [
        'key' => 'not-a-real-key',
        'secret' => 'not-a-real-secret',
    ],
]);

$marshalerFactory = new MarshalerFactory();
$marshaler = $marshalerFactory->make();

$client = new Client($dynamoDbClient, new PayloadFactory(new MarshalerFactory()));

$creatTableData =
[
    'TableName' => 'putItemTestTable',
    'AttributeDefinitions' => [
        [
            'AttributeName' => 'Id',
            'AttributeType' => 'N' 
        ]
    ],
    'KeySchema' => [
        [
            'AttributeName' => 'Id',
            'KeyType' => 'HASH' 
        ]
    ],
    'ProvisionedThroughput' => [
            'ReadCapacityUnits'  => 1,
            'WriteCapacityUnits' => 1
    ]
];

$putItemdata = 
[
    'Id' => 543269300594,
    'name' => [
        'first'  => 'Jeremy',
        'middle' => 'C',
        'last'   => 'Lindblom',
    ],
    'age' => 30,
    'phone_numbers' => [
        [
            'type'      => 'mobile',
            'number'    => '5555555555',
            'preferred' => true
        ],
        [
            'type'      => 'home',
            'number'    => '5555555556',
            'preferred' => false
        ],
    ],
];

/** ========= Create table ========= */
// $response = $dynamoDbClient->createTable($creatTableData);
// $dynamoDbClient->waitUntil('TableExists', array('TableName' => 'putItemTestTable'));
// var_dump($response);exit;

/** ========= Put Item ========= */
//$response = $dynamoDbClient->listTables();
// $response = $dynamoDbClient->putItem(['TableName' => 'putItemTestTable', 'Item' => $marshaler->marshalItem($putItemdata)]);
// var_dump($response);exit;

/** ========= Update Item ========= */
// $tableName = 'putItemTestTable';

// $year = 2015;
// $title = 'The Big New Movie';
// $key = $marshaler->marshalJson('
//     {
//         "Id": 543269300594
//     }
// ');
 
// $eav = $marshaler->marshalJson('
//     {
//         ":r": [ "Larry", "Moe", "Curly" ],
//         ":p": 40
//     }
// ');

// $params = [
//     'TableName' => $tableName,
//     'Key' => $key,
//     'UpdateExpression' => 
//         'set myname = :r, age = :p',
//     'ExpressionAttributeValues'=> $eav,
//     'ReturnValues' => 'UPDATED_NEW'
// ];

// $response = $dynamoDbClient->updateItem($params);
// var_dump($response);exit;

$updateItemData =
[
    'myname' => ['first'=>'jim']
];

$key = ['Id' => 543269300594];

$response = $client->update('putItemTestTable', $key, $updateItemData);
var_dump($response);exit;

/** ========= Get Items ========= */
// $response = $dynamoDbClient->getItem(array(
//     'TableName' => 'putItemTestTable',
//     'Key' => array(
//         'Id' => array( 'N' => 543269300594 )
//     )
// ));
// var_dump($response);exit;

// abstraction test
// $response = $client->create('putItemTestTable', $putItemdata);
// var_dump($response);exit;

// $response = $client->update('putItemTestTable', $putItemdata);
// var_dump($response);exit;