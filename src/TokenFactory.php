<?php
namespace AppMain;

use Payum\Core\Registry\StorageRegistryInterface;
use Payum\Core\Security\AbstractTokenFactory;
use Payum\Core\Storage\StorageInterface;

/**
 * to support generating slim specific URL in Payum
 * multi-step token
 */
class TokenFactory extends AbstractTokenFactory
{
    /**
     * slim container
     */
    protected $container;

    /**
     * initialize token factory
     * @param StorageInterface         $tokenStorage    token storage
     * @param StorageRegistryInterface $storageRegistry storage registry
     * @param object                   $container       slim container
     */
    public function __construct(StorageInterface $tokenStorage, StorageRegistryInterface $storageRegistry, $container)
    {
        $this->tokenStorage    = $tokenStorage;
        $this->storageRegistry = $storageRegistry;
        $this->container       = $container;
    }

    /**
     * generateUrl.
     *
     * @method generateUrl
     *
     * @param  string   $path
     * @param  array    $parameters
     * @return string
     */
    protected function generateUrl($path, array $parameters = [])
    {
        // return if path already resolved (not a named path)
        if (strpos($path, '/') > -1) {
            // maybe try to get/convert to full path here?
            return $path;
        }

        return $this->container->get('router')->pathFor($path, $parameters);
    }
}
