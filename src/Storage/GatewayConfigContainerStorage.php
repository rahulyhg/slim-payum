<?php
namespace AppMain\Storage;
use Illuminate\Database\Eloquent\Model;
use Payum\Core\Storage\AbstractStorage;

/**
 * storage that get gateway config from token
 */
class GatewayConfigContainerStorage extends AbstractStorage {
	protected $container;

	public function __construct($modelClass, $container) {
		$this->modelClass = $modelClass;
		$this->container = $container;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param Model $model
	 */
	protected function doUpdateModel($model) {
		// do nothing
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param Model $model
	 */
	protected function doDeleteModel($model) {
		// do nothing
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param Model $model
	 */
	protected function doGetIdentity($model) {
		return new Identity($model->{'gatewayName'}, $model);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return Model|null
	 */
	protected function doFind($id) {
		// do nothing
		$rst = $this->findBy([]);
		return $rst[0];
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return Model|null
	 */
	public function findBy(array $criteria) {
		// return gateway found in token
		$request = $this->container['request'];
		$clientData = $request->getParsedBody();

		// get the object
		$gateway = $clientData['gateway'];
		$rst = new $this->modelClass();
		$rst->setGatewayName($gateway['gatewayName']);
		$rst->setFactoryName($gateway['factoryName']);
		$rst->setConfig($gateway['config']);
		return [$rst];
	}
}