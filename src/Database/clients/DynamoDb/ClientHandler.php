<?php

namespace App\Database\Clients\DynamoDb;

use App\Database\Clients\ClientHandler as ClientHanderInterface;
use App\Database\Clients\DocumentStoreClient;
use Aws\DynamoDb\Exception\DynamoDbException;
use App\Database\Clients\DocumentStoreExpection;

/**
 * handles the client response
 */
class ClientHandler implements ClientHanderInterface
{
    /**
     * client
     *
     * @var DocumentStoreClient
     */
    private $client;

    public function __construct(DocumentStoreClient $client)
    {
        $this->client = $client;
    }

    /**
     * add item to dynamoDB
     *
     * @param  string $table
     * @param  array  $data
     * @return boolean
     */
    public function create(string $table, array $data): bool
    {
        try {
            $this->client->create($table, $data);
        } catch (DynamoDbException $e) {
            $this->exceptionHandler($e);
        }

        return true;
    }

    /**
     * update item in dynamoDB
     *
     * @param  string $table
     * @param  array  $keys
     * @param  array  $data
     * @return boolean
     */
    public function update(string $table, array $keys, array $data): bool
    {
        try {
            $this->client->update($table, $keys, $data);
        } catch (DynamoDbException $e) {
            $this->exceptionHandler($e);
        }

        return true;
    }

    /**
     * get item from dynamoDB
     *
     * @param  string $table
     * @param  array  $keys
     * @return array
     */
    public function get(string $table, array $keys): array
    {
        try {
            $response = $this->client->get($table, $keys);
        } catch (DynamoDbException $e) {
            $this->exceptionHandler($e);
        }
 
        return $response;
    }

    /**
     * handle 3rd party expection, throw generic db expection
     *
     * @param DynamoDbException $e
     * @return void
     * @throws DocumentStoreExpection
     */
    private function exceptionHandler(DynamoDbException $e)
    {
        throw new DocumentStoreExpection($e->getMessage());
    }
}