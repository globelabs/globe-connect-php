<?php
require_once(__DIR__ . '/autoload.php');

use Globe\Connect\Payment;

$payment = new Payment('[token]');

// payment request
$payment->setEndUserId('[user_id]');
$payment->setAmount('[amount]');
$payment->setDescription('[description]');
$payment->setReferenceCode('[reference_code]');
$payment->setTransactionOperationStatus('[status]');
print $payment->sendPaymentRequest();

// get last reference code request
$payment->setAppKey('[key]');
$payment->setAppSecret('[secret]');
print $payment->getLastReferenceCode();
