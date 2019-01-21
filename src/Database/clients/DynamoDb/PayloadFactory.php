<?php

namespace App\Database\Clients\DynamoDb;

use App\Database\Clients\DynamoDb\Payload\PutItem;
use App\Database\Clients\DynamoDb\Payload\UpdateItem;
use App\Database\Clients\DynamoDb\Payload\GetItem;
use App\Database\Clients\DynamoDb\Payload\Payload;

/**
 * payload factory
 */
class PayloadFactory
{
    /**
     * Marshaler Factory
     *
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
     * get PutItem payload class
     *
     * @return Payload
     */
    public function makePutItem(): Payload
    {
        return new PutItem($this->marshaler);
    }

    /**
     * get UpdateItem payload class
     *
     * @return Payload
     */
    public function makeUpdateItem(): Payload
    {
        return new UpdateItem($this->marshaler);
    }

    /**
     * get GetItem payload class
     *
     * @return Payload
     */
    public function makeGetItem(): Payload
    {
        return new GetItem($this->marshaler);
    }
}
