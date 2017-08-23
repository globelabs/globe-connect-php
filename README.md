
## Globe Connect for PHP

### Setting Up

```composer require globelabs/globe-connect-php```

### Authentication

#### Overview

If you haven't signed up yet, please follow the instructions found in [Getting Started](http://www.globelabs.com.ph/docs/#getting-started-create-an-app) to obtain an `App ID` and `App Secret` these tokens will be used to validate most of your interaction requests with the Globe APIs.

    The authenication process follows the protocols of **OAuth 2.0**. The example code below shows how you can swap your app tokens for an access token.

#### Sample Code

```php
use Globe\Connect\Oauth;

$oauth = new Oauth("[key]", "[secret]");

// get redirect url
echo $oauth->getRedirectUrl();

// redirect to dialog and process the code then ...

// get access token
$oauth->setCode("[code]");
echo $oauth->getAccessToken();
```

#### Sample Results

```json
{
    "access_token":"1ixLbltjWkzwqLMXT-8UF-UQeKRma0hOOWFA6o91oXw",
    "subscriber_number":"9171234567"
}
```

### SMS

#### Overview

Short Message Service (SMS) enables your application or service to send and receive secure, targeted text messages and alerts to your Globe / TM subscribers.

        Note: All API calls must include the access_token as one of the Universal Resource Identifier (URI) parameters.

#### SMS Sending

Send an SMS message to one or more mobile terminals:

##### Sample Code

```php
use Globe\Connect\Sms;

$sms = new Sms("[sender]", "[token]");

$sms->setReceiverAddress("[address]");
$sms->setMessage("[message]");
$sms->setClientCorrelator("[correlator]");
echo $sms->sendMessage();
```

##### Sample Results

```json
{
    "outboundSMSMessageRequest": {
        "address": "tel:+639175595283",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/8011/requests?access_token=3YM8xurK_IPdhvX4OUWXQljcHTIPgQDdTESLXDIes4g"
        },
        "senderAddress": "8011",
        "outboundSMSTextMessage": {
            "message": "Hello World"
        },
        "receiptRequest": {
            "notifyURL": "http://test-sms1.herokuapp.com/callback",
            "callbackData": null,
            "senderName": null,
            "resourceURL": "https://devapi.globelabs.com.ph/smsmessaging/v1/outbound/8011/requests?access_token=3YM8xurK_IPdhvX4OUWXQljcHTIPgQDdTESLXDIes4g"
        }
    }
}
```

#### SMS Binary

Send binary data through SMS:

##### Sample Code

```php
use Globe\Connect\Sms;

$sms = new Sms("[sender]", "[token]");
$sms->setReceiverAddress("[address]");
$sms->setUserDataHeader("[header]");
$sms->setDataEncodingScheme("[scheme]");
$sms->setMessage("[message]");
echo $sms->sendBinaryMessage();
```

##### Sample Results

```json
{
    "outboundBinaryMessageRequest": {
        "address": "9171234567",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/binarymessaging/v1/outbound/{senderAddress}/requests?access_token={access_token}",
        "senderAddress": "21581234",
        "userDataHeader": "06050423F423F4",
        "dataCodingScheme": 1,
        "outboundBinaryMessage": {
            "message": "samplebinarymessage"
        },
        "receiptRequest": {
          "notifyURL": "http://example.com/notify",
          "callbackData": null,
          "senderName": null
        },
        "resourceURL": "https://devapi.globelabs.com.ph/binarymessaging/v1/outbound/{senderAddress}/requests?access_token={access_token}"
    }
}
```

#### SMS Mobile Originating (SMS-MO)

Receiving an SMS from globe (Mobile Originating - Subscriber to Application):

##### Sample Code

```php
// print post data from your callback url
print_r(json_encode($_POST));
```

##### Sample Results

```json
{
  "inboundSMSMessageList":{
      "inboundSMSMessage":[
         {
            "dateTime":"Fri Nov 22 2013 12:12:13 GMT+0000 (UTC)",
            "destinationAddress":"tel:21581234",
            "messageId":null,
            "message":"Hello",
            "resourceURL":null,
            "senderAddress":"9171234567"
         }
       ],
       "numberOfMessagesInThisBatch":1,
       "resourceURL":null,
       "totalNumberOfPendingMessages":null
   }
}
```

### Voice

#### Overview

The Globe APIs has a detailed list of voice features you can use with your application.

#### Voice Ask

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web Api");
$choices = $voice->choices("[5 DIGITS]");
$askSay = $voice->say("Please enter yout 5 digit zip code.");

$ask = $voice->ask($askSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName("foo")
    ->setRequired(true)
    ->setTimeout(10);

$on = $voice->on("continue")
    ->setNext("http://somefakehost.com:8000/")
    ->setRequired(true);

echo $voice->addSay($say)
    ->addAsk($ask)
    ->addOn($on);
```

##### Sample Results

```json
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            ask: {
                choices: {
                    value: "[5 DIGITS]"
                },
                attempts: 3,
                bargein: false,
                name: "foo",
                required: true,
                say: {
                    value: "Please enter your 5 digit zip code."
                },
                timeout: 10
            }
        },
        {
            on: {
                event: "continue",
                next: "http://somefakehost.com:8000/",
                required: true
            }
        }
    ]
}
```

#### Voice Answer

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo Web Api.");
echo $voice->addSay($say);
```

##### Sample Results

```json
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            hangup: { }
        }
    ]
}
```

#### Voice Ask Answer

A better sample of the Ask and Answer dialog would look like the following.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web API");

$voice->addSay($say);

if($url == "/ask") {
    $choices = $voice->choices("[5 DIGITS]");
    $askSay = $voice->say("Please enter yout 5 digit zip code.");

    $ask = $voice->ask($askSay)
        ->setChoices($choices)
        ->setAttempts(3)
        ->setBargein(false)
        ->setName("foo")
        ->setRequired(true)
        ->setTimeout(10);

    $on = $voice->on("continue")
        ->setNext("/answer")
        ->setRequired(true);

    $voice->addSay($say)
        ->addAsk($ask)
        ->addOn($on);
} elseif($url == "/answer") {
    $result = $voice->result($data)
        ->getObject();

    $interprertation = $result["actions"]["ineterpretation"];
    $say = $voice->say("Your zip is " . $interpretation . ", thank you!");

    $voice->addSay($say);
}

echo $voice;
```

##### Sample Results

```json
if path is ask?

{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            ask: {
                choices: {
                    value: "[5 DIGITS]"
                },
                attempts: 3,
                bargein: false,
                name: "foo",
                required: true,
                say: {
                    value: "Please enter your 5 digit zip code."
                },
                timeout: 10
            }
        },
        {
            on: {
                event: "continue",
                next: "/askanswer/answer",
                required: true
            }
        }
    ]
}

if path is answer?

{
    tropo: [
        {
            say: {
                value: "Your zip code is 52521, thank you!"
            }
        }
    ]
}
```

#### Voice Call

You can connect your app to also call a customer to initiate the Ask and Answer features.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();
$call = $voice->call("9065263453")
    ->setFrom("sip:21584130@sip.tropo.net");

$say = $voice->say("Hello World");

echo $voice->addCall($call)
    ->addSay($say);
```

##### Sample Results

```json
{
    tropo: [
        {
            call: {
                to: "9065272450",
                from: "sip:21584130@sip.tropo.net"
            }
        },
        [
            {
                value: "Hello World"
            }
        ]
    ]
}
```

#### Voice Conference

You can take advantage of Globe's automated Ask protocols to help service your customers without manual intervention for common questions in example.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo Web API Conference Call.");

$jPrompt = $voice->joinPrompt("http://openovate.com/hold-music.mp3");
$lPrompt = $voice->leavePrompt("http://openovate.com/hold-music.mp3");

$conference = $voice->conference("12345")
    ->setMute(false)
    ->setName("foo")
    ->setPlayTones(true)
    ->setTerminator("#")
    ->setJoinPrompt($jPrompt)
    ->setLeavePrompt($lPrompt);

echo $voice->addSay($say)
    ->addConference($conference);
```

##### Sample Results

```json
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API Conference Call."
        }
        },
        {
            conference: {
                id: "12345",
                mute: false,
                name: "foo",
                playTones: true,
                terminator: "#",
                joinPrompt: {
                    value: "http://openovate.com/hold-music.mp3"
                },
                leavePrompt: {
                    value: "http://openovate.com/hold-music.mp3"
                }
            }
        }
    ]
}
```

#### Voice Event

Call events are triggered depending on the response of the receiving person. Events are used with the Ask and Answer features.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$e1 = $voice->say("Sorry, I did not hear anything.")
    ->setEvent("timeout");

$e2 = $voice->say("Sorry, that was not a valid option.")
    ->setEvent("nomatch:1");

$e3 = $voice->say("Nope, still not a valid response.")
    ->setEvent("nomatch:2");

$say = $voice->say("Welcome to my Tropo Web API");
$eventSay = $voice->say("Please enter your 5 digit zip code.")
    ->setEvent(array($e1, $e2, $e3));

$choices = $voice->choices("[5 DIGITS]");
$ask = $voice->ask($eventSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName("foo")
    ->setRequired(true)
    ->setTimeout(10);

$on = $voice->on("continue")
    ->setNext("/answer")
    ->setRequired(true);

echo $voice->addSay($say)
    ->addAsk($ask)
    ->addOn($on);
```

##### Sample Results

```json
{
tropo: [
    {
        say: {
            value: "Welcome to my Tropo Web API."
        }
    },
    {
        ask: {
                choices: {
                    value: "[5 DIGITS]"
                },
                attempts: 3,
                bargein: false,
                name: "foo",
                required: true,
                say: [
                    {
                        value: "Sorry, I did not hear anything.",
                        event: "timeout"
                    },
                    {
                        value: "Sorry, that was not a valid option.",
                        event: "nomatch:1"
                    },
                    {
                        value: "Nope, still not a valid response",
                        event: "nomatch:2"
                    },
                    {
                        value: "Please enter your 5 digit zip code."
                    }
                ],
                timeout: 5
            }
        },
        {
            on: {
                event: "continue",
                next: "http://somefakehost:8000/",
                required: true
            }
        }
    ]
}
```

#### Voice Hangup

Between your automated dialogs (Ask and Answer) you can automatically close the voice call using this feature. 

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web Api, Thank you");
echo $say->addSay($say)
    ->addHangup("");
```

##### Sample Results

```json
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API, thank you!"
            }
        },
        {
            hangup: { }
        }
    ]
}
```

#### Voice Record

It is helpful to sometime record conversations, for example to help improve on the automated dialog (Ask and Answer). The following sample shows how you can use connect your application with voice record features.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web API.");
$sayTimeout = $voice->say("Sorry, I did not here anything. Please call back.")
    ->setEvent("timeout");

$say2 = $voice->say("Please leave a message")
    ->setEvent(array($sayTimeout));

$choices = $voice->choices()
    ->setTerminator("#");

$transcription = $voice->transcription("1234")
    ->setUrl("mailto:charles.andacc@gmail.com");

$record = $voice->record("foo", "http://openovate.com/globe.php")
    ->setFormat("wav")
    ->setAttempts(3)
    ->setBargein(false)
    ->setMethod("POST")
    ->setRequired(true)
    ->setSay($say2)
    ->setChoices($choices)
    ->setTranscription($transcription);

echo $voice->addSay($say)
    ->addRecord($record);
```

##### Sample Results

```json
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            record: {
                attempts: 3,
                bargein: false,
                method: "POST",
                required: true,
                say: [
                    {
                        value: "Sorry, I did not hear anything. Please call back.",
                        event: "timeout"
                    },
                    {
                        value: "Please leave a message"
                    }
                ],
                name: "foo",
                url: "http://openovate.com/globe.php",
                format: "audio/wav",
                choices: {
                    terminator: "#"
                },
                transcription: {
                    id: "1234",
                    url: "mailto:charles.andacc@gmail.com"
                }
            }
        }
    ]
}
```

#### Voice Reject

To filter incoming calls automatically, you can use the following example below. 

##### Sample Code

```php
use Globe\Connect\Voice

$voice = new Voice();

echo $voice->addreject("");
```

##### Sample Results

```json
{
    tropo: [
        {
            reject: { }
        }
    ]
}
```

#### Voice Routing

To help integrate Globe Voice with web applications, this API using routing which can be easily routed within your framework.

##### Sample Code

```php
use Globe\Connect\Voice

$voice = new Voice();

if($url == "/routing") {
    $say = $voice->say("Welcome to my Tropo Web API.");
    $on = $voice->on("continue")
        ->setNext("/routing1");

    $voice->addSay($say)
        ->addOn($on);
} else if($url == "/routing1") {
    $say = $voice->say("Hello from resource one.");
    $on = $voice->on("continue")
        ->setNext("/routing2");

    $voice->addSay($say)
        ->addOn($on);
} else if($url == "/routing2") {
    $say = $voice->say("Hello from resource two! Thank you.");
    $voice->addSay($say);
}

echo $voice;
```

##### Sample Results

```json
if path is routing?

{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            on: {
                next: "/VoiceSample/RoutingTest1",
                event: "continue"
            }
        }
    ]
}

if path is routing1?

{
    tropo: [
        {
            say: {
                value: "Hello from resource one!"
            }
        },
        {
            on: {
                next: "/VoiceSample/RoutingTest2",
                event: "continue"
            }
        }
    ]
}

if path is routing2?

{
    tropo: [
        {
            say: {
                value: "Hello from resource two! thank you."
            }
        }
    ]
}
```

#### Voice Say

The message you pass to `say` will be transformed to an automated voice.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo web API");
$say2 = $voice->say("I will play an audio file for you, please wait.");
$say3 = $voice->say("http://openovate.com/tropo-rocks.mp3");

echo $voice->addSay($say)
    ->addSay($say2)
    ->addSay($say3);
```

##### Sample Results

```json
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API."
            }
        },
        {
            say: {
                value: "I will play an audio file for you, please wait."
            }
        },
        {
            say: {
                value: "http://openovate.com/tropo-rocks.mp3"
            }
        }
    ]
}
```

#### Voice Transfer

The following sample explains the dialog needed to transfer the receiver to another phone number.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

$say = $voice->say("Welcome to my Tropo Web API, you are now being transfered.");

$e1 = $voice->say("Sorry I did not hear anything")
    ->setEvent("timeout");

$e2 = $voice->say("Sorry, that was an invalid option")
    ->setEvent("nomatch:1");

$eventSay = $voice->say("Please enter your 5 digit zip code")
    ->setEvent(array($e1, $e2));

$choices = $voice->choices("[5 DIGITS]");
$ask = $voice->ask($eventSay)
    ->setChoices($choices)
    ->setAttempts(3)
    ->setBargein(false)
    ->setName("foo")
    ->setRequired(true)
    ->setTimeout(5);

$ringSay = $voice->say("http://openovate.com/hold-music.mp3");
$onRing = $voice->on("ring")
    ->setSay($ringSay);

$onConnect = $voice->on("connect")
    ->setAsk($ask);

$on = array($onRing, $onConnect);
$transfer = $voice->transfer("9053801178")
    ->setRingRepeat(2)
    ->setOn($on);

echo $voice->addSay($say)
    ->addTransfer($transfer);
```

##### Sample Results

```json
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API, you are now being transferred."
            }
        },
        {
            transfer: {
                to: "9053801178",
                ringRepeat: 2,
                on: [
                    {
                        event: "ring",
                        say: {
                            value: "http://openovate.com/hold-music.mp3"
                        }
                    },
                    {
                        event: "connect",
                        ask: {
                            choices: {
                                value: "[5 DIGITS]"
                            },
                            attempts: 3,
                            bargein: false,
                            name: "foo",
                            required: true,
                            say: [
                                {
                                    value: "Sorry, I did not hear anything.",
                                    event: "timeout"
                                },
                                {
                                    value: "Sorry, that was not a valid option.",
                                    event: "nomatch:1"
                                },
                                {
                                    value: "Nope, still not a valid response",
                                    event: "nomatch:2"
                                },
                                {
                                    value: "Please enter your 5 digit zip code."
                                }
                            ],
                            timeout: 5
                        }
                    }
                ]
            }
        }
    ]
}
```

#### Voice Transfer Whisper

TODO

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();

if($url == "/whisper") {
    $say = $voice->say("Welcome to my Tropo Web API");
    $askSay = $voice->say("Press 1 to continue this call or any other to reject");
    $choices = $voice->choices("1")
        ->setMode("DTMF");

    $ask = $voice->ask($askSay)
        ->setChoices($choices)
        ->setName("color")
        ->setTimeout(60);

    $onConnect1 = $voice->on("connect")
        ->setAsk($ask);

    $sayCon2 = $voice->say("You are now being connected");
    $onConnect2 = $voice->on("connect")
        ->setSay($sayCon2);

    $sayRing = $voice->say("http://openovate.com/hold-music.mp3");
    $onRing = $voice->on("ring")
        ->setSay($say);

    $on = array($onRing, $onConnect1, $onConnect2);
    $transfer = $voice->transfer("9054799241")
        ->setName("foo")
        ->setOn($on)
        ->setRequired(true)
        ->terminator("*")

    $incompleteSay = $voice->say("Your are now being disconnected");
    $onIncomplete = $voice->on("incomplete")
        ->setNext("/whisperIncomplete")
        ->setSay($incompleteSay);

    echo $voice->addSay($say)
        ->addTransfer($transfer)
        ->addOn($onIncomplete);
} else if($url == "/whisperIncomplete") {
    echo $voice->addHangup("");
}
```

##### Sample Results

```json
if transfer whisper?

{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API, please hold while you are being transferred."
            }
        },
        {
            transfer: {
                to: "9054799241",
                name: "foo",
                on: [
                    {
                        event: "ring",
                        say: {
                            value: "http://openovate.com/hold-music.mp3"
                        }
                    },
                    {
                        event: "connect",
                        ask: {
                            choices: {
                                value: "1",
                                mode: "dtmf"
                            },
                            name: "color",
                            say: {
                                value: "Press 1 to accept this call or any other number to reject"
                            },
                            timeout: 60
                        }
                    },
                    {
                        event: "connect",
                        say: {
                            value: "You are now being connected."
                        }
                    }
                ],
                required: true,
                terminator: "*"
            }
        },
        {
            on: {
                event: "incomplete",
                next: "/transferwhisper/hangup",
                say: {
                    value: "You are now being disconnected."
                }
            }
        }
    ]
}

if hangup?

{
    tropo: [
        {
            hangup: { }
        }
    ]
}
```

#### Voice Wait

To put a receiver on hold, you can use the following sample.

##### Sample Code

```php
use Globe\Connect\Voice;

$voice = new Voice();
$say = $voice->say("Welcome to my Tropo Web API.");
$wait = $voice->wait(5000)
    ->setAllowSignals(true);

$say2 = $voice->say("Thank you for waiting.");

echo $voice->addSay($say)
    ->addWait($wait)
    ->addSay($say2);
```

##### Sample Results

```json
{
    tropo: [
        {
            say: {
                value: "Welcome to my Tropo Web API, please wait for a while."
            }
        },
        {
            wait: {
                milliseconds: 5000,
                allowSignals: true
            }
        },
        {
            say: {
                value: "Thank you for waiting!"
            }
        }
    ]
}
```

### USSD

#### Overview

USSD are basic features built on most smart phones which allows the phone owner to interact with menu item choices.

#### USSD Sending

The following example shows how to send a USSD request.

##### Sample Code

```php
use Globe\Connect\Ussd;

$ussd = new Ussd("[token]", "[shortcode]");

// send ussd request
$ussd->setAddress("[address]");
$ussd->setUssdMessage("[message]");
$ussd->setFlash("[flash]");

print $ussd->sendUssdRequest();
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

#### USSD Replying

The following example shows how to send a USSD reply.

##### Sample Code

```php
use Globe\Connect\Ussd;

$ussd = new Ussd("[token]", "[shortcode]");

$ussd->setAddress("[address]");
$ussd->setUssdMessage("[message]");
$ussd->setFlash("[flash]");
$ussd->setSessionId("[session_id]");

print $ussd->replyUssdRequest();
```

##### Sample Results

```json
{
    "outboundUSSDMessageRequest": {
        "address": "639954895489",
        "deliveryInfoList": {
            "deliveryInfo": [],
            "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
        },
        "senderAddress": "21580001",
        "outboundUSSDMessage": {
            "message": "Simple USSD Message\nOption - 1\nOption - 2"
        },
        "receiptRequest": {
            "ussdNotifyURL": "http://example.com/notify",
            "sessionID": "012345678912",
            "referenceID": "f7b61b82054e4b5e"
        },
        "resourceURL": "https://devapi.globelabs.com.ph/ussd/v1/outbound/21589996/reply/requests?access_token=access_token"
    }
}
```

### Payment

#### Overview

Your application can monetize services from customer's phone load by sending a payment request to the customer, in which they can opt to accept.

#### Payment Requests

The following example shows how you can request for a payment from a customer.

##### Sample Code

```php
use Globe\Connect\Payment;

$payment = new Payment("[token]");

// payment request
$payment->setEndUserId("[user_id]");
$payment->setAmount("[amount]");
$payment->setDescription("[description]");
$payment->setReferenceCode("[reference_code]");
$payment->setTransactionOperationStatus("[status]");
print $payment->sendPaymentRequest();
```

##### Sample Results

```json
{
    "amountTransaction":
    {
        "endUserId": "9171234567",
        "paymentAmount":
        {
            "chargingInformation":
            {
                "amount": "0.00",
                "currency": "PHP",
                "description": "my application"
            },
            "totalAmountCharged": "0.00"
        },
        "referenceCode": "12341000023",
        "serverReferenceCode": "528f5369b390e16a62000006",
        "resourceURL": null
    }
}
```

#### Payment Last Reference

The following example shows how you can get the last reference of payment.

##### Sample Code

```php
use Globe\Connect\Payment;

// get last reference code request
$payment->setAppKey("[key]");
$payment->setAppSecret("[secret]");
print $payment->getLastReferenceCode();
```

##### Sample Results

```json
{
    "referenceCode": "12341000005",
    "status": "SUCCESS",
    "shortcode": "21581234"
}
```

### Amax

#### Overview

Amax is an automated promo builder you can use with your app to award customers with certain globe perks.

#### Sample Code

```php
use Globe\Connect\Amax;

$amax = new Amax("[app_id]", "[app_secret]");
$amax->setToken("[token]");
$amax->setAddress("[address]");
$amax->setPromo("[promo]");
echo $amax->sendReward();
```

#### Sample Results

```json
{
    "outboundRewardRequest": {
        "transaction_id": 566,
        "status": "Please check your AMAX URL for status",
        "address": "9065272450",
        "promo": "FREE10MB"
    }
}
```

### Location

#### Overview

To determine a general area (lat,lng) of your customers you can utilize this feature.

#### Sample Code

```php
use Globe\Connect\Location;

$location = new Location("[token]");
$location->setAddress("[address]");
$location->setRequestedAccuracy("[accuracy]");
echo $location->getLocation();
```

#### Sample Results

```json
{
    "terminalLocationList": {
        "terminalLocation": {
            "address": "tel:9171234567",
            "currentLocation": {
                "accuracy": 100,
                "latitude": "14.5609722",
                "longitude": "121.0193394",
                "map_url": "http://maps.google.com/maps?z=17&t=m&q=loc:14.5609722+121.0193394",
                "timestamp": "Fri Jun 06 2014 09:25:15 GMT+0000 (UTC)"
            },
            "locationRetrievalStatus": "Retrieved"
        }
    }
}
```

### Subscriber

#### Overview

Subscriber Data Query API interface allows a Web application to query the customer profile of an end user who is the customer of a mobile network operator.

#### Subscriber Balance

The following example shows how you can get the subscriber balance.

##### Sample Code

```php
use Globe\Connect\Subscriber;

$subscriber = new Subscriber("[token]");
$subscriber->setAddress("[address]");
print $subscriber->getSubscriberBalance();
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                subBalance: "60200"
            }
        ]
    }
}
```

#### Subscriber Reload

The following example shows how you can get the subscriber reload amount.

##### Sample Code

```php
use Globe\Connect\Subscriber;

$subscriber = new Subscriber("[token]");
$subscriber->setAddress("[address]");
print $subscriber->getReloadAmount();
```

##### Sample Results

```json
{
    "terminalLocationList":
    {
        "terminalLocation":
        [
            {
                address: "639171234567",
                reloadAmount: "30000"
            }
        ]
    }
}
```
