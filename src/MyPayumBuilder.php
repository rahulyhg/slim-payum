<?php
namespace AppMain;

use Payum\Core\PayumBuilder;
use Payum\OmnipayBridge\OmnipayGatewayFactory;

class MyPayumBuilder extends \Payum\Core\PayumBuilder {
	/**
	 * @param GatewayFactoryInterface $coreGatewayFactory
	 *
	 * @return GatewayFactoryInterface[]
	 */
	protected function buildOmnipayGatewayFactories(\Payum\Core\GatewayFactoryInterface $coreGatewayFactory) {
		$gatewayFactories = parent::buildOmnipayGatewayFactories($coreGatewayFactory);
		$factory = \Omnipay\Omnipay::getFactory();

		// add firstdata_payeezy
		$type = 'FirstData_Payeezy';
		$gatewayFactories[strtolower('omnipay_' . $type)] = new \Payum\OmnipayBridge\OmnipayGatewayFactory($type, $factory, [], $coreGatewayFactory);

		return $gatewayFactories;
	}
}