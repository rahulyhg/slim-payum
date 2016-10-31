<?php
namespace AppMain\Controller;

use Payum\Core\Payum;
use Payum\Core\Request\Capture;
use Payum\Core\Request\GetHumanStatus;

class PaymentController extends \SlimDash\Core\SlimDashController {
	/**
	 * post to charge a card
	 */
	public function postCharge() {
		$request = $this->request;
		$body = $request->getParsedBody();

		// payum initialisation can also be done here for single php file type of code
		// but it's cleaner to keep the code in our container
		$payum = $this->payum;

		// lookup gateway by name, this mean gateway configuration is required for POST data
		// it should look something like this:
		/*
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
	    	}
		*/
		$gateway = $payum->getGateway($body['gateway']['gatewayName']);

		// create a Capture request with the order data
		// similar to gateway config, order data are also gateway implementation specific
		/*
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
		 */
		$request = new Capture($body['order']);

		// immediately execute the capture request
		$gateway->execute($request);

		// get capture result
		$captureResult = $request->getModel();

		// create a status request
		$status = new \Payum\Core\Request\GetHumanStatus($captureResult);

		// immediately execute the status request
		$gateway->execute($status);

		// return the result
		$this->response->withJson(['status' => $status->getValue(), 'order' => $status->getFirstModel()], 200);
	}
}