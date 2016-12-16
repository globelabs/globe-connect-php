<?php
require_once (__DIR__ . '/autoload.php');

use Globe\Connect\Subscriber;

$subscriber = new Subscriber('[token]');
$subscriber->setAddress('[address]');
print $subscriber->getSubscriberBalance();
