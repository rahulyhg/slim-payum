<?php
namespace AppMain\Storage;
use Illuminate\Database\Eloquent\Model;
use Payum\Core\Model\Identity;
use Payum\Core\Storage\AbstractStorage;

/**
 * store token in memory
 */
class TokenMemoryStorage extends AbstractStorage {
	private $myData = [];

	/**
	 * {@inheritDoc}
	 *
	 * @param Model $model
	 */
	protected function doUpdateModel($model) {
		$this->myData[$model->getHash()] = $model;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param Model $model
	 */
	protected function doDeleteModel($model) {
		$this->myData[$model->getHash()] = null;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @param Model $model
	 */
	protected function doGetIdentity($model) {
		return new Identity($model->{'hash'}, $model);
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return Model|null
	 */
	protected function doFind($id) {
		return $this->myData[$id];
	}

	/**
	 * {@inheritDoc}
	 *
	 * @return Model|null
	 */
	public function findBy(array $criteria) {
		if (false == $criteria) {
			return [];
		}
	}
}