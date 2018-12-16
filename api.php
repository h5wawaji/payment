<?php
require 'api.inc.php';
if ($_POST['type'] && $_POST['notify_url'] && $_POST['amount'] > 0) {
  $type = $_POST['type'];
  $amount = number_format($_POST['amount'],2);
  $order_no = date("YmdHis").rand(1000, 9999);
  $notify_url = $_POST['notify_url'];
  for ($x=0; $x<=100; $x++) {
    if ($database->has("paylogs", [ "type" => $type,"amount" => $amount,"i" => 0 ])){
	   $amount = $amount + 0.01;
    }else{
      break;
    }
  }

  if ($type == 'alipay') {
    $ret = $alipay;
  } elseif ($type == 'wxpay') {
    $ret = $wxpay;
  }
    $database->insert("paylogs", [
       "order_no" => $order_no,
       "amount" => $amount,
       "notify_url" => $notify_url,
       "type" => $type
    ]);
    echo json_encode(['content' => $ret , 'order_no' => $order_no , 'amount' => $amount]);
} else {
    echo 'false';
}


