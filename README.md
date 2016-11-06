# slim-payum
Example of payum with Slim3.

## run/debug
```
composer install
php -S 0.0.0.0:8888 -t public
```

## Goals
To create a simple API endpoint for credit cards payment.

1) It should not persist anything.

2) All configurations should be passed to the API via POST.

3) Project is setup as skeleton so that it can easily convert to persist data. 

4) Deploy anywhere: cpanel, docker, etc...

# Implementation
The plan is to demonstrate the five most common methods in Credit Card payment transaction:

1) *Authorize* - put a hold on the credit card with a certain amount.

2) *Capture* - this is called after authorize to charge the card.

3) *Purchase* - this is doing both Authorize then Capture at the same time.

4) *Cancel/Void* - to cancel or void the transaction.  Usually done on the same day to prevent daily transaction reconsolication.

5) *Refund* - to issue a refund for the transaction.

At this time, we're only demonstrating the *Purchase* transaction.

## Example
[omnipay_authorizenet_aim GatewayFactory example](https://github.com/slimdash/slim-payum/blob/master/docs/omnipay_authorizenet_aim.md)
[omnipay_firstdata_payeezy GatewayFactory example](https://github.com/slimdash/slim-payum/blob/master/docs/omnipay_firstdata_payeezy.md)
[payeezy GatewayFactory example](https://github.com/slimdash/slim-payum/blob/master/docs/payeezy.md)

...

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

## Pros
1) Secure since we do not store anything?

2) Micro-service style/architecture.

3) Easy to add new payment gateways provided by Payum and Omnipay.

## Cons
1) Add another layer of complexity?  This code provide a good starting point/example.  For better flexibility, developer can use it as example to implement payment directly into their own framework.

2) Anytime there is a new network layer, there is a possibility of man-in-the-middle attack.  This kind of service should run behind SSL in Production.  It's easy to obtain cheap or free SSL these day with service such as https://letsencrypt.org/

# LICENSE
The MIT License (MIT)

Copyright (c) 2016 noogen

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
