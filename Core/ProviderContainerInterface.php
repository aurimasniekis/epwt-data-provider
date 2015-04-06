<?php

namespace EPWT\Cache\DataProviderBundle\Core;

use EPWT\Cache\DataProviderBundle\Exception\ProviderNotFoundException;

/**
 * Interface ProviderContainerInterface
 * @package EPWT\Cache\DataProviderBundle\Core
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
interface ProviderContainerInterface
{
    /**
     * @param string $name
     * @param ProviderInterface $provider
     *
     * @return $this
     */
    public function addProvider($name, $provider);

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasProvider($name);

    /**
     * @param string $name
     *
     * @return ProviderInterface
     * @throws ProviderNotFoundException
     */
    public function getProvider($name);

    /**
     * @param string $name
     *
     * @return $this
     */
    public function removeProvider($name);

    /**
     * @return ProviderInterface[]
     */
    public function getProviders();
}
