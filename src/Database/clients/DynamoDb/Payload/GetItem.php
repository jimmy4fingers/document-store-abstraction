<?php

namespace App\Database\Clients\DynamoDb\Payload;

use App\Database\Clients\DynamoDb\Marshaler;

/**
 * class creats GetItem payloads to use with AWS SDK DynamoDbClient class
 */
class GetItem implements Payload
{
    /**
     * @var Marshaler
     */
    private $marshaler;

    /**
     * @param Marshaler $marshaler
     */
    public function __construct(Marshaler $marshaler)
    {
        $this->marshaler = $marshaler;
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
        return $this->getPayload($this->marshaler, $table, $keys);
    }

    /**
     * creates DynamoDB "getItem" payload
     *
     * @param  Marshaler $marshaler
     * @param  string    $table
     * @param  array     $keys
     * @return array
     */
    private function getPayload(Marshaler $marshaler, string $table, array $keys): array
    {
        $payload = [
            'TableName' => $table,
            'Key' => $marshaler->marshalItem($keys)
        ];

        return $payload;
    }
}
