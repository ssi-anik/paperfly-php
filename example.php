<?php

require_once "vendor/autoload.php";

use Anik\Paperfly\Client;
use Anik\Paperfly\CreateOrder;

$username = getenv('PAPERFLY_USERNAME');
$password = getenv('PAPERFLY_PASSWORD');
$requiredHeaderValue = getenv('PAPERFLY_REQUIRED_HEADER_VALUE');

if (empty($username) || empty($password)) {
    die('Either username or password is not configured');
}

function create_order()
{
    $phoneNumber = getenv('PHONE_NUMBER') ?? '01701701701';

    return CreateOrder::buildFrom([
        "order_id" => uniqid('oid_'),
        /*"merchant_name" => "test",
        "merchant_address" => "test",
        "merchant_thana" => "Banani",
        "merchant_district" => "Dhaka",*/
        "merchant_phone" => $phoneNumber,
        "product_size_weight" => "standard",
        "product_brief" => "USB Fan",
        "weight_in_kilo" => "1",
        "package_price" => "0",
        "delivery_option" => "regular",
        "customer_name" => "Abin Hasan",
        "customer_address" => "Road 27, Dhanmondi",
        "customer_thana" => "Banani",
        "customer_district" => "Dhaka",
        "customer_phone" => $phoneNumber,
        "special_instruction" => "open box",
        "order_type" => "regular",
    ]);
}

$client = Client::useDefaultGuzzleClient($username, $password, $requiredHeaderValue);

switch ($argv[1] ?? '') {
    case 'create_order':
        $transferable = create_order();
        break;
    default:
        throw new Exception('Invalid command');
}

dd($client->gracefulTransfer($transferable));
