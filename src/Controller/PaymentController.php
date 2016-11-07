<?php
namespace AppMain\Controller;

use Payum\Core\Payum;
use Payum\Core\Request;

class PaymentController extends \SlimDash\Core\SlimDashController {
	/**
	 * Execute the actual request
	 * @param  string $className 'Payum\Core\Request\(Authorize|Capture|Cancel|Refund'
	 */
	public function executeRequest($className) {
		$request = $this->request;
		$body = $request->getParsedBody();

		// all of payum init can also be done here for single php file coding style
		// but it's cleaner to keep that code in our container
		$payum = $this->payum;

		// lookup gateway by name; therefore, gateway configuration is required
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

		// create a request with the payment data
		// similar to gateway config, payment data are also gateway specific
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

		// immediately execute the request
		$gateway->execute($request);

		// get request result
		$captureResult = $request->getModel();

		// create a status request
		$status = new \Payum\Core\Request\GetHumanStatus($captureResult);

		// immediately execute the status request
		$gateway->execute($status);

		// return the result
		$this->response
			->withJson([
				'status' => $status->getValue(),
				'payment' => $status->getFirstModel(),
			], 200);
	}

	/**
	 * post Authorize
	 */
	public function postAuthorize() {
		$this->executeRequest('\Payum\Core\Request\Authorize');
	}

	/**
	 * post Capture
	 */
	public function postCapture() {
		$this->executeRequest('\Payum\Core\Request\Capture');
	}

	/**
	 * post Cancel
	 */
	public function postCancel() {
		$this->executeRequest('\Payum\Core\Request\Cancel');
	}

	/**
	 * post Refund
	 */
	public function postRefund() {
		$this->executeRequest('\Payum\Core\Request\Refund');
	}
}