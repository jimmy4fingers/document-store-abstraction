<?php

namespace App\Database\Client\DynamoDb\Payload;

use App\Database\Client\DynamoDb\MarshalerFactory;

/**
 * class creats GetItem payloads to use with AWS SDK DynamoDbClient class
 */
class GetItem implements Payload
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
     * @param  string $table
     * @param  array  $keys
     * @return array
     */
    public function get(string $table, array $keys): array
    {
        return $this->getPayload($this->marshalerFactory->make(), $table, $keys);
    }

    /**
     * creates DynamoDB "getItem" payload
     *
     * @param  Marshaler $marshaler
     * @param  string    $table
     * @param  array     $keys
     * @return array
     */
    private function getPayload(\Aws\DynamoDb\Marshaler $marshaler, string $table, array $keys): array
    {
        $payload = [
            'TableName' => $table,
            'Key' => $marshaler->marshalItem($keys)
        ];

        return $payload;
    }
}
