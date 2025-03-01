<?php

require_once "vendor/autoload.php";

use Anik\Paperfly\Client;
use Anik\Paperfly\Transfers\CancelOrder;
use Anik\Paperfly\Transfers\CreateOrder;
use Anik\Paperfly\Transfers\TrackOrder;

$username = getenv('PAPERFLY_USERNAME');
$password = getenv('PAPERFLY_PASSWORD');
$requiredHeaderValue = getenv('PAPERFLY_REQUIRED_HEADER_VALUE');

if (empty($username) || empty($password)) {
    die('Either username or password is not configured');
}

function create_order(?string $type = null): CreateOrder
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
        "weight_in_kilo" => "1.2",
        "package_price" => "2345",
        "delivery_option" => "regular",
        "customer_name" => "Abin Hasan",
        "customer_address" => "Road 27, Dhanmondi",
        "customer_thana" => "Banani",
        "customer_district" => "Dhaka",
        "customer_phone" => $phoneNumber,
        "special_instruction" => "open box",
        "order_type" => $type ?? "regular",
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
        $transferable = create_order($argv[2] ?? 'regular');
        echo sprintf('Creating order for: %s', $transferable->requestBody()['merOrderRef']).PHP_EOL;
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

$response = $client->gracefulTransfer($transferable);
/**
 * Create order
 */
/*dd(
    $response->isSuccessful()
        ? ['tracking' => $response->trackingNumber(), 'barcode' => $response->trackingBarcode()]
        : $response->message()
);*/

/**
 * Track order
 */
/*dd(
    \Anik\Paperfly\orderStatus($response->content()['success']['trackingStatus'][0]),
    $response->currentStatus()
);*/
dd(
    $response->isSuccessful(), // http returns a successful response
    $response->wasTransferred(), // was transferred via the wire, network error will return false
    $response->message(), // when successful, it will be null, otherwise error/exception message
    $response->contentRaw(), // raw data if successfully sent over the wire
    // associative array of the content, null if content is empty, empty array if data cannot be `json_decode`d
    $response->content(),
    // \stdClass of the content, null if content is empty, empty \stdClass if data cannot be `json_decode`d
    $response->content(false),
    $response
);
