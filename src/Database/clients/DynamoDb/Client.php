<?php

namespace App\Database\Clients\DynamoDb;

use App\Database\Clients\DocumentStoreClient;
use Aws\AwsClientInterface;

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
     * client response
     *
     * @var mixed
     */
    private $response;

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

        $this->response = $this->dynamoDbClient->putItem(
            $putItemPayload->get($table, $data)
        );

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

        $this->response = $this->dynamoDbClient->updateItem(
            $updateItemPayload->get($table, $data)
        );

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

        $this->response = $this->dynamoDbClient->getItem(
            $getItemPayload->get($table, $keys)
        );

        if (is_null($this->response['Item'])) {
            return [];
        }
    
        return $this->response['Item'];
    }

     /**
      * get the last client response.
      *
      * @return mixed
      */
    public function getLastResponse()
    {
        return $this->response;
    }
}
