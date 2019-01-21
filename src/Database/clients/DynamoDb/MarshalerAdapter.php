<?php

namespace App\Database\Clients\DynamoDb;

use Aws\DynamoDb\Marshaler as AwsMarshaler;
use App\Database\Clients\DynamoDb\Marshaler;

/**
 * 3rd party AWS Marshaler class adaptor
 */
class MarshalerAdapter extends AwsMarshaler implements Marshaler
{
}
