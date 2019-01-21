<?php

namespace App\Database\Clients\DynamoDb;

interface Marshaler
{
    /**
     * @return array Item formatted for DynamoDB.
     */
    public function marshalItem($item);
}