<?php 

namespace App\Database\Client\DynamoDb\Payload;

use App\Database\Client\DynamoDb\MarshalerFactory;

/**
 * class creats PutItem payloads to use with AWS SDK DynamoDbClient class
 */
class PutItem implements Payload
{
    /**
     * @var MarshalerFactory
     */
    private $marshalerFactory;

    /**
     * @param MarshalerFactory $marshalerFactory
     */
    public function __construct(MarshalerFactory $marshalerFactory)
    {
        $this->marshalerFactory = $marshalerFactory;
    }

    /**
     * gets DynamoDB "putItem" payload
     *
     * @param string $table
     * @param array $data
     * @return array
     */
    public function get(string $table, array $data): array
    {
        return $this->getPayload($this->marshalerFactory->make(), $table, $data);
    }

    /**
     * creates DynamoDB "putItem" payload
     *
     * @param Marshaler $marshaler
     * @param string $table
     * @param array $data
     * @return array
     */
    private function getPayload(\Aws\DynamoDb\Marshaler $marshaler, string $table, array $data): array
    {
        $item = $marshaler->marshalJson(
            json_encode($data)
        );

        $payload = [
            'TableName' => $table,
            'Item' => $item
        ];

        return $payload;
    }
}