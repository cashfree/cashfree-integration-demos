<?php
//import client
require __DIR__ . '/vendor/autoload.php';
error_reporting(E_ERROR | E_PARSE);

//Credential Detail
$appId = "APPID";
$secretKey = "SECRETKEY";

$jsonData = file_get_contents('php://input');

// Convert the JSON data to a PHP associative array
$entity = json_decode($jsonData, true);

//Order detail
$order_amount = $entity['order_amount'];
$order_currency = $entity['order_currency'];
$order_id = $entity["order_id"];

//Customer Detail
$customer_id = $entity['customer_id'];
$customer_phone = $entity['customer_phone'];

//Order meta Detail
$return_url = 'https://your_domain.com/php/return.php?orderId={order_id}';

try {

    $cfConfig = new \Cashfree\CFInterface\CFConfig(\Cashfree\CFInterface\CFEnvironment::PRODUCTION, $appId, $secretKey);
    $cfHeader = new \Cashfree\CFInterface\CFHeader("x_request_id");

    $data = [
        "order_id" => "$order_id",
        "order_currency" => "$order_currency",
        "order_amount" => $order_amount,
        "customer_details" => [
            "customer_id" => "$customer_id",
            "customer_phone" => "$customer_phone"
        ],
        "order_meta" => [
            "return_url"=>"$return_url",
        ],
        "order_note" => "some order note here"
    ];

    $cfOrderRequest = new \Cashfree\Model\CFOrderRequest($data);
    $apiInstance = new \Cashfree\CFInterface\CFPaymentGateway();
    $result = $apiInstance->createOrder($cfConfig, $cfHeader, $cfOrderRequest);
} catch (ApiException $e) {
    echo $e->getResponseBody();
}

echo json_encode($result->cfOrder);

?>