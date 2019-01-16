<?php

namespace App\Database\Client;

/**
 * Storage client Adaptor
 */
interface DocumentStoreClient
{
    /**
     * add item to the storage engine
     *
     * @param  array $data
     * @return boolean
     */
    public function create(string $table, array $data): bool;
    
    /**
     * update item in the storage engine
     *
     * @param  array $keys
     * @param  array $data
     * @return boolean
     */
    public function update(string $table, array $keys, array $data): bool;

    /**
     * get item from the storage engine
     *
     * @param  string $table
     * @param  array  $keys
     * @return array
     */
    public function get(string $table, array $keys): array;
}
