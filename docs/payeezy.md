# Payeezy
Before you start, signup and obtain a sandbox account with Payeezy: https://developer.payeezy.com

Login and obtain: apiKey, apiSecret, and merchantToken from the sandbox.

## Note
In this example, we implemented Payeezy GatewayFactory with Payum on a separate git repo: https://github.com/slimdash/payum-payeezy

Then we add this factory to PayumBuilder like so:
```php
// add custom gateway factory
$builder->addGatewayFactory('payeezy', function (array $config, GatewayFactoryInterface $coreGatewayFactory) {
   return new \Payum\Payeezy\PayeezyGatewayFactory($config, $coreGatewayFactory);
});
```


## PURCHASE
```
curl -i -X POST -H "Content-Type: application/json" http://localhost:8888/api/payment/capture -d  '{
   "gateway": {
     "gatewayName": "test",
     "factoryName": "payeezy",
     "config": {
         "apiKey": "bfvCs2v0BlGr2GlKn55b5iDeRDcX0AMs",
         "apiSecret": "4012faf411afc618b77f0703ad1c37be8eff8d8337e8e7571364d35c49edf003",
         "merchantToken": "fdoa-a480ce8951daa73262734cf102641994c1e55e7cdf4c02b6",
         "sandbox": true
     }
   },
   "payment": {
      "merchant_ref": "Astonishing-Sale",
      "transaction_type": "purchase",
      "method": "credit_card",
      "amount": "1299",
      "currency_code": "USD",
      "credit_card": {
        "type": "visa",
        "cardholder_name": "John Smith",
        "card_number": "4788250000028291",
        "exp_date": "1020",
        "cvv": "123"
      }
   }
}'
```

### PURCHASE Result
```json
{
   "status":"captured",
   "payment":{
      "merchant_ref":"Astonishing-Sale",
      "transaction_type":"purchase",
      "method":"credit_card",
      "amount":"1299",
      "partial_redemption":"false",
      "currency_code":"USD",
      "credit_card":{
         "type":"visa",
         "cardholder_name":"John Smith",
         "card_number":"4788250000028291",
         "exp_date":"1020",
         "cvv":"123"
      },
      "correlation_id":"228.1478467218828",
      "transaction_status":"approved",
      "validation_status":"success",
      "transaction_id":"ET138881",
      "transaction_tag":"117402746",
      "currency":"USD",
      "cvv2":"M",
      "token":{
         "token_type":"FDToken",
         "token_data":{
            "value":"2539440474298291"
         }
      },
      "card":{
         "type":"visa",
         "cardholder_name":"John Smith",
         "card_number":"8291",
         "exp_date":"1020"
      },
      "bank_resp_code":"100",
      "bank_message":"Approved",
      "gateway_resp_code":"00",
      "gateway_message":"Transaction Normal"
   }
}
```

## AUTHORIZE
Same as first CURL example above, just change the post path to /api/payment/authorize and "transaction_type" parameter.

```
curl -i -X POST -H "Content-Type: application/json" http://localhost:8888/api/payment/authorize -d  '{
   ...
      "transaction_type": "authorize",
   ...
}'
```

### AUTHORIZE Result
Pay attention to "transaction_id" and "transaction_tag" values.  You can use these later to cancel/void the transaction later.

```json
{
   "status":"authorized",
   "payment":{
      "merchant_ref":"Astonishing-Sale",
      "transaction_type":"authorize",
      "method":"credit_card",
      "amount":"1299",
      "partial_redemption":"false",
      "currency_code":"USD",
      "credit_card":{
         "type":"visa",
         "cardholder_name":"John Smith",
         "card_number":"4788250000028291",
         "exp_date":"1020",
         "cvv":"123"
      },
      "correlation_id":"228.1478472108044",
      "transaction_status":"approved",
      "validation_status":"success",
      "transaction_id":"ET164426",
      "transaction_tag":"117403898",
      "currency":"USD",
      "cvv2":"M",
      "token":{
         "token_type":"FDToken",
         "token_data":{
            "value":"9385691864008291"
         }
      },
      "card":{
         "type":"visa",
         "cardholder_name":"John Smith",
         "card_number":"8291",
         "exp_date":"1020"
      },
      "bank_resp_code":"100",
      "bank_message":"Approved",
      "gateway_resp_code":"00",
      "gateway_message":"Transaction Normal"
   }
}
```

## CANCEL
```
curl -i -X POST -H "Content-Type: application/json" http://localhost:8888/api/payment/refund -d  '{
   "gateway": {
     "gatewayName": "test",
     "factoryName": "payeezy",
     "config": {
         "apiKey": "bfvCs2v0BlGr2GlKn55b5iDeRDcX0AMs",
         "apiSecret": "4012faf411afc618b77f0703ad1c37be8eff8d8337e8e7571364d35c49edf003",
         "merchantToken": "fdoa-a480ce8951daa73262734cf102641994c1e55e7cdf4c02b6",
         "sandbox": true
     }
   },
   "payment": {
      "merchant_ref": "Astonishing-Sale",
      "transaction_tag": "117405287",
      "transaction_id": "ET179892",
      "transaction_type": "void",
      "method": "credit_card",
      "amount": "1299",
      "currency_code": "USD"
   }
}'
```

### CANCEL Result
```json
{
   "status":"canceled",
   "payment":{
      "merchant_ref":"Astonishing-Sale",
      "transaction_tag":"117405308",
      "transaction_type":"void",
      "method":"credit_card",
      "amount":"1299",
      "currency_code":"USD",
      "correlation_id":"228.1478478222295",
      "transaction_status":"approved",
      "validation_status":"success",
      "transaction_id":"ET198662",
      "currency":"USD",
      "token":{
         "token_type":"FDToken",
         "token_data":{
            "value":"7321856970018291"
         }
      },
      "bank_resp_code":"100",
      "bank_message":"Approved",
      "gateway_resp_code":"00",
      "gateway_message":"Transaction Normal"
   }
}
```

## REFUND
Same as first CURL example above, just change the post path to /api/payment/refund and "transaction_type" parameter.

```
curl -i -X POST -H "Content-Type: application/json" http://localhost:8888/api/payment/refund -d  '{
   ...
      "transaction_type": "refund",
   ...
}'
```

You can refund with or without the two "transaction_id" and "transaction_tag" value.

### REFUND Result
The result below is to refund provided a credit card so there is no need for the "transaction_id" and "transaction_tag" values.
```json
{
   "status":"refunded",
   "payment":{
      "merchant_ref":"Astonishing-Sale",
      "transaction_type":"refund",
      "method":"credit_card",
      "amount":"1299",
      "currency_code":"USD",
      "credit_card":{
         "type":"visa",
         "cardholder_name":"John Smith",
         "card_number":"4788250000028291",
         "exp_date":"1020",
         "cvv":"123"
      },
      "correlation_id":"228.1478472637217",
      "transaction_status":"approved",
      "validation_status":"success",
      "transaction_id":"ET187422",
      "transaction_tag":"117404003",
      "currency":"USD",
      "cvv2":"M",
      "card":{
         "type":"visa",
         "cardholder_name":"John Smith",
         "card_number":"8291",
         "exp_date":"1020"
      },
      "bank_resp_code":"100",
      "bank_message":"Approved",
      "gateway_resp_code":"00",
      "gateway_message":"Transaction Normal"
   }
}
```

