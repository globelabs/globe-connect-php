<?php
require_once(__DIR__ . '/autoload.php');

use Globe\Connect\Oauth;

$oauth = new Oauth('[key]', '[secret]');

// get redirect url
echo $oauth->getRedirectUrl();

// get access token
$oauth->setCode('[code]');
echo $oauth->getAccessToken();
