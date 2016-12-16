<?php
require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();
echo $voice->addReject('');
