<?php
require_once(__DIR__ . '/autoload.php');

use Globe\Connect\Sms;

$sms = new Sms('[sender]', '[token]');

// send message
$sms->setReceiverAddress('[address]');
$sms->setMessage('[message]');
$sms->setClientCorrelator('[correlator]');
echo $sms->sendMessage();

// send binary message
$sms->setReceiverAddress('[address]');
$sms->setUserDataHeader('[header]');
$sms->setDataEncodingScheme('[scheme]');
$sms->setMessage('[message]');
echo $sms->sendBinaryMessage();
