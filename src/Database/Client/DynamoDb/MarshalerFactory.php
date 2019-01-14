<?php 

namespace App\Database\Client\DynamoDb;

use Aws\DynamoDb\Marshaler;

class MarshalerFactory
{
    public function make()
    {
        return new Marshaler();
    }
}