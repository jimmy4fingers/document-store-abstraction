<?php 

namespace App\Database\Client\DynamoDb\Payload;

use App\Database\Client\DynamoDb\MarshalerFactory;

interface Payload
{
    public function __construct(MarshalerFactory $marshalerFactory);
    public function get(string $table, array $data): array;
}