# OMNIPAY - AuthorizeNet - AIM
Before you start, signup and obtain a sandbox account with AuthorizeNet: https://developer.authorize.net/

Login to the console and obtain an apiLoginId and transactionKey.

## POST
```
curl -i -X POST -H "Content-Type: application/json" http://localhost:8888/api/payment/capture -d  '{
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
    "payment": {
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

## Result
```json
{
    "status": "captured",
    "payment": {
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