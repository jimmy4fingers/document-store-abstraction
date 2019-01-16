<?php

namespace App\Database\Client\DynamoDb;

use App\Database\Client\DynamoDb\Payload\PutItem;
use App\Database\Client\DynamoDb\Payload\UpdateItem;
use App\Database\Client\DynamoDb\Payload\GetItem;
use App\Database\Client\DynamoDb\Payload\Payload;

/**
 * payload factory
 */
class PayloadFactory
{
    /**
     * Marshaler Factory
     *
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
     * get PutItem payload class
     *
     * @return Payload
     */
    public function makePutItem(): Payload
    {
        return new PutItem($this->marshalerFactory);
    }

    /**
     * get UpdateItem payload class
     *
     * @return Payload
     */
    public function makeUpdateItem(): Payload
    {
        return new UpdateItem($this->marshalerFactory);
    }

    /**
     * get GetItem payload class
     *
     * @return Payload
     */
    public function makeGetItem(): Payload
    {
        return new GetItem($this->marshalerFactory);
    }
}
