<?php

require(__dir__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say('Welcome to my Tropo Web API, you are now being transfered.');

$e1 = $voice->say('Sorry I did not hear anything')
    ->setEvent('timeout');

$e2 = $voice->say('Sorry, that was an invalid option')
    ->setEvent('nomatch:1');

$eventSay = $voice->say('Please enter your 5 digit zip code')
    ->setEvent(array($e1, $e2));

$choices = $voice->choices('[5 DIGITS]');
$ask = $voice->ask($eventSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName('foo')
    ->setRequired(true)
    ->setTimeout(5);

$ringSay = $voice->say('http://openovate.com/hold-music.mp3');
$onRing = $voice->on('ring')
    ->setSay($ringSay)
    ->getObject();

$onConnect = $voice->on('connect')
    ->setAsk($ask)
    ->getObject();

$on = array($onRing, $onConnect);
$transfer = $voice->transfer('9053801178')
    ->setRingRepeat(2)
    ->setOn($on);

echo $voice->addSay($say)
    ->addTransfer($transfer);
