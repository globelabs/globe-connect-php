<?php
require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();

$e1 = $voice->say('Sorry, I did not hear anything.')
    ->setEvent('timeout');

$e2 = $voice->say('Sorry, that was not a valid option.')
    ->setEvent('nomatch:1');

$e3 = $voice->say('Nope, still not a valid response.')
    ->setEvent('nomatch:2');

$say = $voice->say('Welcome to my Tropo Web API');
$eventSay = $voice->say('Please enter your 5 digit zip code.')
    ->setEvent(array($e1, $e2, $e3));

$choices = $voice->choices('[5 DIGITS]');
$ask = $voice->ask($eventSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName('foo')
    ->setRequired(true)
    ->setTimeout(10);

$on = $voice->on('continue')
    ->setNext('/answer')
    ->setRequired(true);

echo $voice->addSay($say)
    ->addAsk($ask)
    ->addOn($on);

