<?php

namespace App\Database\Clients\DynamoDb\Payload;

use App\Database\Clients\DynamoDb\Marshaler;

/**
 * payload classes interface
 */
interface Payload
{
    /**
     * @param Marshaler $marshaler
     */
    public function __construct(Marshaler $marshaler);

    /**
     * gets payload array
     *
     * @param  string $table
     * @param  array  $data
     * @return array
     */
    public function get(string $table, array $data): array;
}
