<?php

namespace EPWT\Cache\DataProviderBundle\Core;

use EPWT\Cache\DataProviderBundle\Cache\CacheDriverInterface;
use EPWT\Cache\DataProviderBundle\Exception\ProviderNotFoundException;

/**
 * Class BaseProviderContainer
 * @package EPWT\Cache\DataProviderBundle\Core
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
abstract class BaseProviderContainer implements ProviderContainerInterface
{
    /**
     * @var ProviderTypesContainer
     */
    protected $providerTypesContainer;

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
     * @var ProviderInterface
     */
    protected $providers;

    public function __construct()
    {
        $this->providers = [];
    }

    /**
     * @param string $name
     * @param ProviderInterface $provider
     *
     * @return $this
     */
    public function addProvider($name, $provider)
    {
        $this->providers[$name] = $provider;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasProvider($name)
    {
        return array_key_exists($name, $this->providers);
    }

    /**
     * @param string $name
     *
     * @return ProviderInterface
     * @throws ProviderNotFoundException
     */
    public function getProvider($name)
    {
        if (!$this->hasProvider($name)) {
            throw new ProviderNotFoundException($name);
        }

        return $this->providers[$name];
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeProvider($name)
    {
        unset($this->providers[$name]);

        return $this;
    }

    /**
     * @return ProviderInterface[]
     */
    public function getProviders()
    {
        return $this->providers;
    }

}
