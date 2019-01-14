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
     * @param array $data
     * @return boolean
     */
    public function create(string $table, array $data): bool;
    
    /**
     * update item in the storage engine
     *
     * @param string $id
     * @param array $data
     * @return boolean
     */
    public function update(string $table, string $id, array $data): bool;

    /**
     * @todo public function query($options);
     */
}