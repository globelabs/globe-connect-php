<?php
require(__DIR__ . '/../tests/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say('Welcome to my Tropo Web Api');
$choices = $voice->choices('[5 DIGITS]');
$askSay = $voice->say("Please enter yout 5 digit zip code.");

$ask = $voice->ask($askSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName('foo')
    ->setRequired(true)
    ->setTimeout(10);

$on = $voice->on('continue')
    ->setNext('http://somefakehost.com:8000/')
    ->setRequired(true);

echo $voice->addSay($say)
    ->addAsk($ask)
    ->addOn($on);
