<?php
//import client
require __DIR__ . '/vendor/autoload.php';
error_reporting(E_ERROR | E_PARSE);

//Credential Detail
$appId = "APPID";
$secretKey = "SECRETKEY";

try {
  $cfConfig = new \Cashfree\CFInterface\CFConfig(\Cashfree\CFInterface\CFEnvironment::PRODUCTION, $appId, $secretKey);
  $cfHeader = new \Cashfree\CFInterface\CFHeader("x_request_id_asdasd2234");

  $apiInstance = new \Cashfree\CFInterface\CFPaymentGateway();
  $result = $apiInstance->getOrder($cfConfig, $cfHeader, $_GET['orderId']);
  $result->getCFOrder();
  echo '<pre>';
  print_r($result->getCFOrder());
  die();
} catch (ApiException $e) {
  echo $e->getResponseBody();
}
