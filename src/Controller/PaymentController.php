<?php
namespace AppMain\Controller;

use Payum\Core\Payum;
use Payum\Core\Request\Capture;
use Payum\Core\Request\GetHumanStatus;

class PaymentController extends \SlimDash\Core\SlimDashController {
	public function execute($className) {
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

		// create a Capture request with the payment data
		// similar to gateway config, payment data are also gateway implementation specific
		/*
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
		 */
		$request = new $className($body['payment']);

		// immediately execute the capture request
		$gateway->execute($request);

		// get capture result
		$captureResult = $request->getModel();

		// create a status request
		$status = new \Payum\Core\Request\GetHumanStatus($captureResult);

		// immediately execute the status request
		$gateway->execute($status);

		// return the result
		return $this->response->withJson(['status' => $status->getValue(), 'payment' => $status->getFirstModel()], 200);
	}

	/**
	 * post Authorize
	 */
	public function postAuthorize() {
		return $this->execute('\Payum\Core\Request\Authorize');
	}

	/**
	 * post Capture
	 */
	public function postCapture() {
		return $this->execute('\Payum\Core\Request\Capture');
	}

	/**
	 * post Cancel
	 */
	public function postCancel() {
		return $this->execute('\Payum\Core\Request\Cancel');
	}

	/**
	 * post Refund
	 */
	public function postRefund() {
		return $this->execute('\Payum\Core\Request\Refund');
	}
}