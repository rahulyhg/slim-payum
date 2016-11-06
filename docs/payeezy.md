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


## POST
```
curl -i -X POST -H "Content-Type: application/json" http://localhost:8888/api/payment/purchase -d  '{
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
   "order": {
      "merchant_ref": "Astonishing-Sale",
      "transaction_type": "purchase",
      "method": "credit_card",
      "amount": "1299",
      "partial_redemption": "false",
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

## Result
```json
{
   "status":"captured",
   "order":{
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
