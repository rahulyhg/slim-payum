# slim-payum
Example of payum with Slim3.  Below describes the process we took in developing this demo.

0.1.0
- demonstrates omnipay_authorizenet_aim

0.1.1
- demonstrating how to add omnipay_firstdata_payeezy
At the time, omnipay/omnipay does not reference firstdata_payeezy so we manually add it.  This mean that we have to remove reference from omnipay/omnipay, update composer.json to match, and create custom PayumBuilder to include the new payment type.

## Goals
To create a simple API endpoint for charging credit cards.

1) It should not persist anything.

2) All configurations should be passed to the API via POST.

3) Project is setup as skeleton so that it can easily convert to persist data. 

4) Deploy anywhere: cpanel, docker, etc...

## Benefits/Pros
1) Secure since we do not store anything?

2) Micro-service style/architecture.

3) Easy to add new payment gateways provided by Payum and Omnipay.

## Cons
1) Add another layer of complexity?  This code provide a good starting point/example.  For better flexibility, developer can use it as example to implement payment directly into their own framework.

2) Anytime there is a new network layer, there is a possibility of man-in-the-middle attack.  This kind of service should run behind SSL in Production.  It's easy to obtain cheap or free SSL these day with service such as https://letsencrypt.org/

# Example
The plan is to demonstrate the five most common methods in Credit Card payment transaction:

1) Authorize - put a hold on the credit card with a certain amount.
2) Capture - this is called after authorize to charge the card.
3) Purchase - this is doing both Authorize then Capture at the same time.
4) Cancel/Void - to cancel or void the transaction.  Usually done on the same day to prevent daily transaction reconsolication.
5) Refund - to issue a refund for the transaction.

At this time, we're only demonstrating the Purchase transaction.

## OMNIPAY - AuthorizeNet - AIM
Before you start, signup and obtain a sandbox account with AuthorizeNet: https://developer.authorize.net/

Login to the console and obtain an apiLoginId and transactionKey.

### POST
```
curl -i -X POST -H "Content-Type: application/json" http://localhost:8888/api/payment/purchase -d  '{
    "gateway": {
        "gatewayName": "test",
        "factoryName": "omnipay_authorizenet_aim",
        "config": {
            "apiLoginId": "xxx",
            "transactionKey": "yyy",
            "sandbox": true,
            "testMode": true,
            "developerMode": true
        }
    },
    "order": {
        "amount": 123.00,
        "currency": "USD",
        "card": {
            "number": "5424000000000015",
            "expiryMonth": "12",
            "expiryYear": "20",
            "cvv": "999"
        }
    }
}'
```

### Result
```
{
    "status": "captured",
    "order": {
        "amount": 123,
        "currency": "USD",
        "card": {
            "number": "5424000000000015",
            "expiryMonth": "12",
            "expiryYear": "20",
            "cvv": "999"
        },
        "clientIp": "127.0.0.1",
        "transactionReference": "{\"approvalCode\":\"000000\",\"transId\":\"0\",\"card\":{\"number\":\"0015\",\"expiry\":\"122020\"}}",
        "_data": {
            "messages": {
                "resultCode": "Ok",
                "message": {
                    "code": "I00001",
                    "text": "Successful."
                }
            },
            "transactionResponse": {
                "responseCode": "1",
                "authCode": "000000",
                "avsResultCode": "P",
                "cvvResultCode": {},
                "cavvResultCode": {},
                "transId": "0",
                "refTransID": {},
                "transHash": "0A1A9255A6CDBEA9AF272436245F3EBA",
                "testRequest": "1",
                "accountNumber": "XXXX0015",
                "accountType": "MasterCard",
                "messages": {
                    "message": {
                        "code": "1",
                        "description": "This transaction has been approved."
                    }
                },
                "transHashSha2": "F24F96B5FBD8A3BA607B980F2C096403F462D3AEFA9D476A0F5737BEC73237A57CB77D95EC0EB07A5365883F421526886FF015B905244588EAAE09FD47EAA876"
            }
        },
        "_reference": "{\"approvalCode\":\"000000\",\"transId\":\"0\",\"card\":{\"number\":\"0015\",\"expiry\":\"122020\"}}",
        "_status": "captured",
        "_status_code": null,
        "_status_message": ""
    }
}
```

## more (TODO)
[omnipay_firstdata_payeezy.md](https://github.com/slimdash/slim-payum/blob/master/docs/omnipay_firstdata_payeezy.md)

...

# run/debug

## development
```
php -S 0.0.0.0:8888 -t public
```

## docker
```
TODO
```

# Other Prerequisites
* Payum and Omnipay requires ext-intl

- Install WAMP on windows and just enable this via php.ini

- On other platforms: https://asdqwe.net/blog/enabling-installing-intl-package-php-from-terminal/

-- OSX additional info/debug: https://github.com/phpbrew/phpbrew/wiki/TroubleShooting#configure-error-unable-to-detect-icu-prefix-or-no-failed-please-verify-icu-install-prefix-and-make-sure-icu-config-works


# REFERENCE
This project was created as a learning/tutorial for using Payum, Omnipay, and proof of concept for integrating with Slim.  For questions relating to the various libraries used in this project, please refer to:

slim - https://github.com/slimphp/Slim

payum - https://github.com/payum/payum

omnipay - https://github.com/thephpleague/omnipay

# NOTE
* You can simply put in any site.

# ADDITION
1) Create another microservice that support credit card vault/token capability for gateway such as: AuthorizeNet, Stripe, etc...

2) Create a cart service/plugin that utlize this service...

# LICENSE
The MIT License (MIT)

Copyright (c) 2016 noogen

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
