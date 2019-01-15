<?php 

namespace App\Database\Client\DynamoDb\Payload;

use App\Database\Client\DynamoDb\MarshalerFactory;

/**
 * class creats UpdateItem payloads to use with AWS SDK DynamoDbClient class
 */
class UpdateItem implements Payload
{
    /**
     * @var MarshalerFactory
     */
    private $marshalerFactory;

    /**
     * document name
     *
     * @var string
     */    
    private $table;

    /**
     * search keys
     *
     * @var array
     */
    private $key;

    /**
     * update expression
     *
     * @var string
     */
    private $updateExpression;

    /**
     * conditional update expression
     *
     * @var string
     */
    private $conditionExpression;

    /**
     * key\value pair of attribute\values to be updated
     *
     * @var array
     */
    private $expressionAttributeValues;

    /**
     * Return value type
     *
     * @var string
     */
    private $returnValues = 'UPDATED_NEW';

    /**
     * Update expression type
     *
     * @var string
     */
    private $updateType = 'set';

    /**
     * @param MarshalerFactory $marshalerFactory
     */
    public function __construct(MarshalerFactory $marshalerFactory)
    {
        $this->marshalerFactory = $marshalerFactory;
    }

    /**
     * set table name
     *
     * @param string $value
     * @return void
     */
    public function setTable(string $value)
    {
        $this->table = $value;
    }

    /**
     * set search key
     *
     * @param array $value
     * @return void
     */
    public function setKey(array $value)
    {
        $this->key = json_encode($value);
    }

    /**
     * set update expression
     *
     * @param string $value
     * @return void
     */
    public function setUpdateExpression(string $value)
    {
        $this->updateExpression = $value;
    }

    /**
     * set condition expression
     *
     * @param string $value
     * @return void
     */
    public function setConditionExpression(string $value)
    {
        $this->conditionExpression = $value;
    }

    /**
     * set expression attribute values
     *
     * @param array $value
     * @return void
     */
    public function setExpressionAttributeValues(array $value)
    {
        $this->expressionAttributeValues = json_encode($value);
    }

    /**
     * set return values
     *
     * @param string $value
     * @return void
     */
    public function setReturnValues(string $value)
    {
        $this->returnValues = $value;
    }

    /**
     * gets DynamoDB "updateItem" payload
     *
     * @param string $table
     * @param array $data
     * @return array
     */
    public function get(string $table, array $data): array
    {
        if (is_null($this->key)) {
            throw new \Exception('Key must be set before calling get.');
        }

        $this->setTable($table);
        $this->setUpdateData($data);

        return $this->getPayload($this->marshalerFactory->make());
    }

    /**
     * takes key\value data and sets payload values for 
     * ExpressionAttributeValues & UpdateExpression
     *
     * @param array $data
     * @return void
     */
    private function setUpdateData(array $data)
    {
        $updateExp = [];
        $expressionAttributes = [];

        foreach ($data as $key => $value) {
            $hashkey = ':' . hash("md5", json_encode([$key, $value]));
            $expressionAttributes[$hashkey] = $value;
            $updateExp[] = "$key = $hashkey";
        }

        $updateStr = $this->updateType . ' ' . implode(', ', $updateExp);

        $this->setExpressionAttributeValues($expressionAttributes);
        $this->setUpdateExpression($updateStr);
    }

    /**
     * creates DynamoDB "updateItem" payload
     *
     * @param Marshaler $marshaler
     * @param string $table
     * @param array $data
     * @return array
     */
    private function getPayload(\Aws\DynamoDb\Marshaler $marshaler): array
    {
        $key = $marshaler->marshalJson($this->key);
        $eav = $marshaler->marshalJson($this->expressionAttributeValues);
        
        $payload['TableName'] = $this->table;
        $payload['Key'] = $key;
        $payload['UpdateExpression'] = $this->updateExpression;

        if (!is_null($this->updateExpression)){
            $payload['ConditionExpression'] = $this->conditionExpression;
        }

        $payload['ExpressionAttributeValues'] = $eav;
        $payload['ReturnValues'] = $this->returnValues;

        return $payload;
    }
}