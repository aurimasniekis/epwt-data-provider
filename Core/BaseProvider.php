<?php

namespace EPWT\Cache\DataProviderBundle\Core;

use EPWT\Cache\DataProviderBundle\Cache\CacheDriverInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BaseProvider
 * @package EPWT\Cache\DataProviderBundle\Core
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
abstract class BaseProvider extends ContainerAware implements ProviderInterface
{
    /**
     * @var int
     */
    protected $ttl;

    /**
     * @var CacheDriverInterface
     */
    protected $cacheDriver;

    /**
     * @var ProviderContainerInterface
     */
    protected $providersContainer;

    /**
     * @var ProviderTypesContainer
     */
    protected $providerTypesContainer;

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @return CacheDriverInterface
     */
    public function getCacheDriver()
    {
        return $this->cacheDriver;
    }

    /**
     * @param CacheDriverInterface $cacheDriver
     *
     * @return $this
     */
    public function setCacheDriver($cacheDriver)
    {
        $this->cacheDriver = $cacheDriver;

        return $this;
    }

    /**
     * @return ProviderContainerInterface
     */
    public function getProvidersContainer()
    {
        return $this->providersContainer;
    }

    /**
     * @param ProviderContainerInterface $providersContainer
     *
     * @return $this
     */
    public function setProvidersContainer($providersContainer)
    {
        $this->providersContainer = $providersContainer;

        return $this;
    }

    /**
     * @return ProviderTypesContainer
     */
    public function getProviderTypesContainer()
    {
        return $this->providerTypesContainer;
    }

    /**
     * @param ProviderTypesContainer $providerTypesContainer
     *
     * @return $this
     */
    public function setProviderTypesContainer($providerTypesContainer)
    {
        $this->providerTypesContainer = $providerTypesContainer;

        return $this;
    }

    /**
     * @param int $ttl
     *
     * @return $this
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;

        return $this;
    }

    public function getTTL()
    {
        if ($this->ttl) {
            return $this->ttl;
        }

        return 24 * 60 * 60;
    }

    protected function callBuildKey($arguments)
    {
        if (!is_array($arguments)) {
            $arguments = [$arguments];
        }

        return call_user_func_array([$this, 'buildKey'], $arguments);
    }

    /**
     * @param string|array $arguments
     * @param mixed $value
     *
     * @param bool $buildKey
     *
     * @return bool
     */
    public function setCacheValue($arguments, $value, $buildKey = true, $ttl = null)
    {
        if (!$ttl) {
            $ttl = $this->getTTL();
        }

        if ($buildKey) {
            $key = $this->callBuildKey($arguments);

            return $this->getCacheDriver()->set($key, $value, $ttl);
        } else {
            return $this->getCacheDriver()->set($arguments, $value, $ttl);
        }
    }

    /**
     * @param string|array $arguments
     *
     * @param bool $buildKey
     *
     * @return bool|mixed
     */
    public function getCacheValue($arguments, $buildKey = true)
    {
        if ($buildKey) {
            $key = $this->callBuildKey($arguments);

            return $this->getCacheDriver()->get($key);
        } else {
            return $this->getCacheDriver()->get($arguments);
        }
    }

    /**
     * @param string|array $arguments
     *
     * @param bool $buildKey
     *
     * @return bool
     */
    public function deleteCacheValue($arguments, $buildKey = true)
    {
        if ($buildKey) {
            $key = $this->callBuildKey($arguments);

            return $this->getCacheDriver()->delete($key);
        } else {
            return $this->getCacheDriver()->delete($arguments);
        }
    }
}
