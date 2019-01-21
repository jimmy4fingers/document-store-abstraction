<?php

namespace App\Database\Clients\DynamoDb\Payload;

use App\Database\Clients\DynamoDb\Marshaler;

/**
 * class creats PutItem payloads to use with AWS SDK DynamoDbClient class
 */
class PutItem implements Payload
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
     * @param  array  $data
     * @return array
     */
    public function get(string $table, array $data): array
    {
        return $this->getPayload($this->marshaler, $table, $data);
    }

    /**
     * creates DynamoDB "putItem" payload
     *
     * @param  Marshaler $marshaler
     * @param  string    $table
     * @param  array     $data
     * @return array
     */
    private function getPayload(Marshaler $marshaler, string $table, array $data): array
    {
        $payload = [
            'TableName' => $table,
            'Item' => $marshaler->marshalItem($data)
        ];

        return $payload;
    }
}
