<?php

namespace App\Database\Client\DynamoDb;

use Aws\DynamoDb\Marshaler;

/**
 * AWS Marshaler factory
 */
class MarshalerFactory
{
    /**
     * makes Marshaler
     *
     * @return Marshaler
     */
    public function make(): Marshaler
    {
        return new Marshaler();
    }
}
