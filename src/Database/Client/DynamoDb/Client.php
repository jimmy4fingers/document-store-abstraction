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
     * @param PayloadFactory $factory
     */
    public function __construct(AwsClientInterface $awsDynamoClient, PayloadFactory $factory)
    {
        $this->dynamoDbClient = $awsDynamoClient;
        $this->factory = $factory;
    }

    /**
     * add item to the storage engine
     *
     * @param string $table
     * @param array $data
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
     * update item in the storage engine
     *
     * @param string $table
     * @param string $id
     * @param array $data
     * @return boolean
     */
    public function update(string $table, string $id, array $data): bool
    {
        try {
            $this->responseHandeler = $this->dynamoDbClient->updateItem(
                $this->getUpdateItemPayload($table, $data)
            );
        } catch (DynamoDbException $e) {
            return false;
        }

        return true;
    }

    /**
     * @todo public function query($options);
     */
    public function query()
    {}

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