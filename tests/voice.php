<?php
require_once (__DIR__ .'/autoload.php');

use Globe\Connect\Voice;

$voice = new Voice();

// ask
$ask = $voice->ask('[askSay]');
$ask->setChoices('[askChoices]');
print_r($ask->getObject());
// ask json
print $ask;

// call
$call = $voice->call('[callTo]');
$call->setName('[callName]');
print_r($call->getObject());
// call json
print $call;

// choices
$choices = $voice->choices('[choicesValue]');
print_r($choices->getObject());
// choices json
print $choices;

// conference
$conference = $voice->conference('[conferenceId]');
$conference->setName('[conferenceName]');
print_r($conference->getObject());
// conference json
print $conference;

// join prompt
$joinPrompt = $voice->joinPrompt('[joinPromptValue]');
print_r($joinPrompt->getObject());
// join prompt
print $joinPrompt;

// leave prompt
$leavePrompt = $voice->leavePrompt('[leavePromptValue]');
print_r($leavePrompt->getObject());
// leave prompt json
print $leavePrompt;

// machine detection
$machineDetection = $voice->machineDetection();
$machineDetection->setIntroduction('[machineDetectionIntroduction]');
$machineDetection->setVoice('[machineDetectionVoice]');
print_r($machineDetection->getObject());
// machine detection json
print $machineDetection;

// message
$message = $voice->message('[messageSay]', '[messageTo]');
$message->setName('[messageName]');
print_r($message->getObject());
// message json
print $message;

// on
$on = $voice->on('[onEvent]', '[onSay]');
$on->setName('[onName]');
print_r($on->getObject());
// on json
print $on;

// record
$record = $voice->record('[recordName]', '[recordUrl]');
print_r($record->getObject());
// record json
print $record;

// redirect
$redirect = $voice->redirect('[redirectTo]');
$redirect->setName('[redirectName]');
print_r($redirect->getObject());
// redirect json
print $redirect;

// result
$result = $voice->result('{"result" : { "name" : "resultName", "foo" : "bar" }}');
print_r($result->getObject());
// result json
print $result;

// say
$say = $voice->say('[sayName]', '[sayValue]');
print_r($say->getObject());
// say json
print $say;

// session
$session = $voice->session('{"session" : { "name" : "sessionName", "value" : "sessionValue"}}');
print_r($session->getObject());
// session json
print $session;


// start recording
$startRecording = $voice->startRecording('[startRecordingUrl]');
print_r($startRecording->getObject());
// recording json
print $startRecording;

// transfer
$transfer = $voice->transfer('[transferTo]', '[transferName]');
print_r($transfer->getObject());
// transfer json
print $transfer;

