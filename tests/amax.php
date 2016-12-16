<?php
require_once(__DIR__ . '/autoload.php');

use Globe\Connect\Amax;

$amax = new Amax('[app_id]', '[app_secret]');
$amax->setToken('[token]');
$amax->setAddress('[address]');
$amax->setPromo('[promo]');
echo $amax->sendReward();
