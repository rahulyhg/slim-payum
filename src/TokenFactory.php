<?php
namespace AppMain;

use Payum\Core\Registry\StorageRegistryInterface;
use Payum\Core\Security\AbstractTokenFactory;
use Payum\Core\Storage\StorageInterface;

class TokenFactory extends AbstractTokenFactory {

	protected $container;

	public function __construct(StorageInterface $tokenStorage, StorageRegistryInterface $storageRegistry, $container) {
		$this->tokenStorage = $tokenStorage;
		$this->storageRegistry = $storageRegistry;
		$this->container = $container;
	}

	/**
	 * generateUrl.
	 *
	 * @method generateUrl
	 *
	 * @param string $path
	 * @param array  $parameters
	 *
	 * @return string
	 */
	protected function generateUrl($path, array $parameters = []) {
		// return if path already resolved (not a named path)
		if (strpos($path, '/') > -1) {
			// TODO: maybe try to get full path here?
			return $path;
		}

		return $this->container->get('router')->pathFor($path, $parameters);
	}
}