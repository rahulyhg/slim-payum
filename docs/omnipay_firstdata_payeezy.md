#OMNIPAY - FirstData - Payeezy
Before you start, signup and obtain a sandbox account with FirstData - Payeezy: https://demo.globalgatewaye4.firstdata.com

Login to the console, terminals->ecomm, and obtain an gatewayId, generate password, keyId, and generate hmac.

Ref: https://support.bigcommerce.com/articles/Public/Setting-Up-the-First-Data-e4-Payment-Gateway

The Payeezy API version is v14.  At the time of this writing, omnipay-firstdata was cloned directly from github dev-master with expected version number V2.4.0

This is the old/firstdata payeezy API, *not* to be confused with: https://developer.payeezy.com

## POST
```
curl -i -X POST -H "Content-Type: application/json" http://localhost:8888/api/payment/charge -d  '{
    "gateway": {
        "gatewayName": "test",
        "factoryName": "omnipay_firstdata_payeezy",
        "config": {
            "gatewayId": "www",
            "password": "xxx",
            "keyId": "yyy",
            "hmac": "zzz",
            "sandbox": true,
            "testMode": true,
            "developerMode": true
        }
    },
    "order": {
        "amount": 123.00,
        "currency": "USD",
        "card": {
            "firstName": "John",
            "lastName": "Smith",
            "number": "4788250000028291",
            "expiryMonth": "10",
            "expiryYear": "20",
            "cvv": "123"
        }
    }
}'
```

## Result
```
{
   "status":"captured",
   "order":{
      "amount":"123.0",
      "currency":"USD",
      "card":{
         "firstName":"John",
         "lastName":"Smith",
         "number":"4788250000028291",
         "expiryMonth":"10",
         "expiryYear":"20",
         "cvv":"123"
      },
      "clientIp":"127.0.0.1",
      "transactionReference":"ET148825::116576264",
      "account_number":"",
      "address":"",
      "amount_requested":"",
      "authorization":"",
      "authorization_num":"ET148825",
      "avs":"",
      "bank_id":"",
      "bank_message":"Approved",
      "bank_resp_code":"100",
      "bank_resp_code_2":"",
      "card_cost":"",
      "cardholder_name":"John Smith",
      "cavv":"",
      "cavv_algorithm":"",
      "cavv_response":"",
      "cc_expiry":"1020",
      "cc_number":"############8291",
      "cc_verification_str1":"",
      "cc_verification_str2":"123",
      "check_number":"",
      "check_type":"",
      "clerk_id":"",
      "client_email":"",
      "client_ip":"127.0.0.1",
      "correlation_id":"",
      "credit_card_type":"Visa",
      "ctr":"========== TRANSACTION RECORD ==========\nxxxx DEMO0xxx\nstreet number\nMinneapolis, MN 12345\nUnited States\n\n\nTYPE: Purchase\n\nACCT: Visa                  $ 123.00 USD\n\nCARDHOLDER NAME : John Smith\nCARD NUMBER     : ############8291\nDATE\/TIME       : 31 Oct 16 16:15:38\nREFERENCE #     : 03 000002 M\nAUTHOR. #       : ET148825\nTRANS. REF.     : \n\n    Approved - Thank You 100\n\n\nPlease retain this copy for your records.\n\nCardholder will pay above amount to\ncard issuer pursuant to cardholder\nagreement.\n========================================",
      "currency_code":"USD",
      "current_balance":"",
      "customer_id_number":"",
      "customer_id_type":"",
      "customer_name":"",
      "customer_ref":"",
      "cvd_presence_ind":"1",
      "cvv2":"M",
      "date_of_birth":"",
      "device_id":"",
      "ean":"",
      "ecommerce_flag":"",
      "error_description":"",
      "error_number":"",
      "exact_message":"Transaction Normal",
      "exact_resp_code":"00",
      "fraud_suspected":"",
      "gateway_id":"OE8642-23",
      "gift_card_amount":"",
      "gross_amount_currency_id":"",
      "language":"",
      "logon_message":"",
      "merchant_address":"xx",
      "merchant_city":"xx",
      "merchant_country":"United States",
      "merchant_name":"xx",
      "merchant_postal":"xx",
      "merchant_province":"xx",
      "merchant_url":"",
      "message":"",
      "micr":"",
      "pan":"",
      "partial_redemption":"0",
      "password":"",
      "payer_id":"",
      "previous_balance":"",
      "reference_3":"",
      "reference_no":"",
      "registration_date":"",
      "registration_no":"",
      "release_type":"",
      "retrieval_ref_no":"6950925",
      "secure_auth_required":"",
      "secure_auth_result":"",
      "sequence_no":"000002",
      "special_payment":"",
      "split_tender_id":"",
      "success":"",
      "surcharge_amount":"",
      "tax1_amount":"",
      "tax1_number":"",
      "tax2_amount":"",
      "tax2_number":"",
      "timestamp":"",
      "tpp_id":"",
      "track1":"",
      "track2":"",
      "transaction_approved":"1",
      "transaction_error":"0",
      "transaction_tag":"116576264",
      "transaction_type":"00",
      "transarmor_token":"",
      "user_name":"",
      "vip":"",
      "virtual_card":"",
      "xid":"",
      "zip_code":"",
      "_reference":"ET148825::116576264",
      "_status":"captured",
      "_status_code":"00",
      "_status_message":""
   }
}
```
