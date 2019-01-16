<?php

namespace App\Database\Client\DynamoDb\Payload;

use App\Database\Client\DynamoDb\MarshalerFactory;

/**
 * payload classes interface
 */
interface Payload
{
    /**
     * @param MarshalerFactory $marshalerFactory
     */
    public function __construct(MarshalerFactory $marshalerFactory);

    /**
     * gets payload array
     *
     * @param  string $table
     * @param  array  $data
     * @return array
     */
    public function get(string $table, array $data): array;
}
