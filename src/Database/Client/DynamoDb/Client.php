<?php

namespace App\Database\Client\DynamoDb;

use App\Database\Client\DocumentStoreClient;
use Aws\AwsClientInterface;
use Aws\DynamoDb\Exception\DynamoDbException;

/**
 * AWS DynamoDB client [Adaptor]
 */
class Client implements DocumentStoreClient
{
    /**
     * DynamoDb client
     *
     * @var AwsClientInterface
     */
    private $dynamoDbClient;

    /**
     * Payload factory
     *
     * @var PayloadFactory
     */
    private $factory;

    /**
     * @todo create handler object for responses
     *
     * @var [type]
     */
    private $responseHandeler;

    /**
     * @param AwsClientInterface $awsDynamoClient
     * @param PayloadFactory     $factory
     */
    public function __construct(AwsClientInterface $awsDynamoClient, PayloadFactory $factory)
    {
        $this->dynamoDbClient = $awsDynamoClient;
        $this->factory = $factory;
    }

    /**
     * add item to dynamoDB
     *
     * @param  string $table
     * @param  array  $data
     * @return boolean
     */
    public function create(string $table, array $data): bool
    {
        $putItemPayload = $this->factory->makePutItem();

        try {
            $this->responseHandeler = $this->dynamoDbClient->putItem(
                $putItemPayload->get($table, $data)
            );
        } catch (DynamoDbException $e) {
            return false;
        }

        return true;
    }
    
    /**
     * update item in dynamoDB
     *
     * @param  string $table
     * @param  array  $keys
     * @param  array  $data
     * @return boolean
     */
    public function update(string $table, array $keys, array $data): bool
    {
        $updateItemPayload = $this->factory->makeUpdateItem();
        
        // add search keys
        $updateItemPayload->setKey($keys);

        try {
            $this->responseHandeler = $this->dynamoDbClient->updateItem(
                $updateItemPayload->get($table, $data)
            );
        } catch (DynamoDbException $e) {
            return false;
        }

        return true;
    }

    /**
     * get item from dynamoDB
     *
     * @param  string $table
     * @param  array  $keys
     * @return array
     */
    public function get(string $table, array $keys): array
    {
        $getItemPayload = $this->factory->makeGetItem();

        try {
            $this->responseHandeler = $this->dynamoDbClient->getItem(
                $getItemPayload->get($table, $keys)
            );
        } catch (DynamoDbException $e) {
            return [];
        }

        if (is_null($this->responseHandeler['Item'])) {
            return [];
        }
        
        return $this->responseHandeler['Item'];
    }

     /**
      * get the last client response.
      *
      * @return mixed
      */
    public function getLastResponse()
    {
        return $this->responseHandeler;
    }
}
