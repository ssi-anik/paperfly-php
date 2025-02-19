<?php

require_once "vendor/autoload.php";

use Anik\Paperfly\CancelOrder;
use Anik\Paperfly\Client;
use Anik\Paperfly\CreateOrder;
use Anik\Paperfly\TrackOrder;

$username = getenv('PAPERFLY_USERNAME');
$password = getenv('PAPERFLY_PASSWORD');
$requiredHeaderValue = getenv('PAPERFLY_REQUIRED_HEADER_VALUE');

if (empty($username) || empty($password)) {
    die('Either username or password is not configured');
}

function create_order(): CreateOrder
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

function track_order(string $orderId): TrackOrder
{
    return TrackOrder::orderId($orderId);
}

function cancel_order(string $orderId): CancelOrder
{
    return CancelOrder::orderId($orderId);
}

$client = Client::useDefaultGuzzleClient($username, $password, $requiredHeaderValue);

switch ($command = $argv[1] ?? '') {
    case 'create_order':
        $transferable = create_order();
        echo sprintf('Creating order for: %s', $transferable->requestBody()['merOrderRef']) . PHP_EOL;
        break;
    case 'track_order':
    case 'cancel_order':
        $orderId = $argv[2] ?? '';
        if (empty($orderId)) {
            throw new Exception('Order id cannot be empty');
        }

        if ($command == 'track_order') {
            $transferable = track_order($orderId);
        } else {
            $transferable = cancel_order($orderId);
        }
        break;
    default:
        throw new Exception('Invalid command');
}

dd($client->gracefulTransfer($transferable));
