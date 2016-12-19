# Globe Connect for Android

## Introduction
Globe Connect for PHP provides an implementation of Globe APIs e.g Authentication, Amax,
Sms etc. that is easy to use and can be integrated in your existing PHP application. Below shows
some samples on how to use the API depending on the functionality that you need to integrate in your
application.

## Basic Usage

###### Figure 1. Authentication
```php

use Globe\Connect\Oauth;

$oauth = new Oauth('[key]', '[secret]');

// get redirect url
echo $oauth->getRedirectUrl();

// get access token
$oauth->setCode('[code]');
echo $oauth->getAccessToken();
```

###### Figure 2. Amax
```php
use Globe\Connect\Amax;

$amax = new Amax('[app_id]', '[app_secret]');
$amax->setToken('[token]');
$amax->setAddress('[address]');
$amax->setPromo('[promo]');
echo $amax->sendReward();
```

###### Figure 3. Binary SMS
```php

use Globe\Connect\Sms;

$sms = new Sms('[sender]', '[token]');
$sms->setReceiverAddress('[address]');
$sms->setUserDataHeader('[header]');
$sms->setDataEncodingScheme('[scheme]');
$sms->setMessage('[message]');
echo $sms->sendBinaryMessage();
```

###### Figure 4. Location
```php
use Globe\Connect\Location;

$loc = new Location('[token]');
$loc->setAddress('[address]');
$loc->setRequestedAccuracy('[accuracy]');
echo $loc->getLocation();
```

###### Figure 5. Payment (Send Payment Request)

```php
use Globe\Connect\Payment;

$payment = new Payment('[token]');

// payment request
$payment->setEndUserId('[user_id]');
$payment->setAmount('[amount]');
$payment->setDescription('[description]');
$payment->setReferenceCode('[reference_code]');
$payment->setTransactionOperationStatus('[status]');
print $payment->sendPaymentRequest();
```

###### Figure 6. Payment (Get Last Reference ID)
```php
use Globe\Connect\Payment;

// get last reference code request
$payment->setAppKey('[key]');
$payment->setAppSecret('[secret]');
print $payment->getLastReferenceCode();
```

###### Figure 7. Sms

```php
use Globe\Connect\Sms;

$sms = new Sms('[sender]', '[token]');

$sms->setReceiverAddress('[address]');
$sms->setMessage('[message]');
$sms->setClientCorrelator('[correlator]');
echo $sms->sendMessage();
```


###### Figure 8. Subscriber (Get Balance)


```php
use Globe\Connect\Subscriber;

$subscriber = new Subscriber('[token]');
$subscriber->setAddress('[address]');
print $subscriber->getSubscriberBalance();
```

###### Figure 9. Subscriber (Get Reload Amount)


```php

use Globe\Connect\Subscriber;

$subscriber = new Subscriber('[token]');
$subscriber->setAddress('[address]');
print $subscriber->getReloadAmount();

```

###### Figure 10. USSD (Send)

```php
use Globe\Connect\Ussd;

$ussd = new Ussd('[token]', '[shortcode]');

// send ussd request
$ussd->setAddress('[address]');
$ussd->setUssdMessage('[message]');
$ussd->setFlash('[flash]');

print $ussd->sendUssdRequest();

```

###### Figure 11. USSD (Reply)

```php
use Globe\Connect\Ussd;

$ussd = new Ussd('[token]', '[shortcode]');

$ussd->setAddress('[address]');
$ussd->setUssdMessage('[message]');
$ussd->setFlash('[flash]');
$ussd->setSessionId('[session_id]');

print $ussd->replyUssdRequest();

```
