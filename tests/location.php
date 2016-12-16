<?php
require_once (__DIR__ . '/autoload.php');

use Globe\Connect\Location;

$loc = new Location('[token]');
$loc->setAddress('[address]');
$loc->setRequestedAccuracy('[accuracy]');
echo $loc->getLocation();
