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
    private $dynamo;

    /**
     * Marshaler factory
     *
     * @var MarshalerFactory
     */
    private $marshalerFactory;

    /**
     * @param AwsClientInterface $awsDynamoClient
     * @param MarshalerFactory $marshalerFactory
     */
    public function __construct(AwsClientInterface $awsDynamoClient, MarshalerFactory $marshalerFactory)
    {
        $this->dynamo = $awsDynamoClient;
        $this->marshalerFactory = $marshalerFactory;
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
        try {
            $this->dynamo->putItem($this->getPayload($table, $data));
        } catch (DynamoDbException $e) {
            // @todo use logger
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
        // todo
        return true;
    }

    /**
     * @todo public function query($options);
     */

    /**
     * creates DynamoDB payload
     *
     * @param string $table
     * @param array $data
     * @return array
     */
    private function getPayload(string $table, array $data): array
    {
        $marshaler = $this->marshalerFactory->make();
        $item = $marshaler->marshalJson(json_encode($data));

        $payload = [
            'TableName' => $table,
            'Item' => $item
        ];

        return $payload;
    }
}