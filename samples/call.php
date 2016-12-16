<?php
require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();

$call = $voice->call('sip:9065272450@tropo.net');
$call->setFrom('9065272450');

$say = $voice->say('Hello chawse');

$voice->addCall($call);
$voice->addSay($say);
print $voice;
