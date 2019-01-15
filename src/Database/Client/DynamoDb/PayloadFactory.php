<?php 

namespace App\Database\Client\DynamoDb;

use App\Database\Client\DynamoDb\Payload\PutItem;
use App\Database\Client\DynamoDb\Payload\UpdateItem;
use App\Database\Client\DynamoDb\Payload\Payload;
//use App\Database\Client\Update;

class PayloadFactory
{
    private $marshalerFactory;

    public function __construct(MarshalerFactory $marshalerFactory)
    {
        $this->marshalerFactory = $marshalerFactory;
    }

    public function makePutItem(): Payload
    {
        return new PutItem($this->marshalerFactory);
    }

    public function makeUpdate(): Payload
    {
        return new UpdateItem($this->marshalerFactory);
    }
}