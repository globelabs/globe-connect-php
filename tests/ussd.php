<?php
require_once (__DIR__ . '/autoload.php');

use Globe\Connect\Ussd;

$ussd = new Ussd('[token]', '[shortcode]');

// send ussd request
$ussd->setAddress('[address]');
$ussd->setUssdMessage('[message]');
$ussd->setFlash('[flash]');

print $ussd->sendUssdRequest();

// reply ussd request
$ussd->setAddress('[address]');
$ussd->setUssdMessage('[message]');
$ussd->setFlash('[flash]');
$ussd->setSessionId('[session_id]');

print $ussd->replyUssdRequest();
