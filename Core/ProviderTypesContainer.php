<?php

namespace EPWT\Cache\DataProviderBundle\Core;

use EPWT\Cache\DataProviderBundle\Exception\ProviderTypeAlreadyDefinedException;
use EPWT\Cache\DataProviderBundle\Exception\ProviderTypeNotFoundException;

/**
 * Class ProviderTypesContainer
 * @package EPWT\Cache\DataProviderBundle\Core
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class ProviderTypesContainer
{
    /**
     * @var array
     */
    protected $providerTypes;

    public function __construct()
    {
        $this->providerTypes = [];
    }

    /**
     * @param string $type
     * @param ProviderContainerInterface $providerContainer
     *
     * @return $this
     * @throws ProviderTypeAlreadyDefinedException
     */
    public function addProviderType($type, $providerContainer)
    {
        if ($this->hasProviderType($type)) {
            throw new ProviderTypeAlreadyDefinedException($type);
        }

        $this->providerTypes[$type] = $providerContainer;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public function hasProviderType($type)
    {
        return array_key_exists($type, $this->providerTypes);
    }

    /**
     * @param string $type
     *
     * @return ProviderContainerInterface
     * @throws ProviderTypeNotFoundException
     */
    public function getProviderTypeContainer($type)
    {
        if (!$this->hasProviderType($type)) {
            throw new ProviderTypeNotFoundException($type);
        }

        return $this->providerTypes[$type];
    }

    /**
     * Return provider types
     *
     * @return array
     */
    public function getProviderTypes()
    {
        return array_keys($this->providerTypes);
    }

    /**
     * @return ProviderContainerInterface[]
     */
    public function getProviderTypesContainers()
    {
        return $this->providerTypes;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function removeProviderType($type)
    {
        unset($this->providerTypes[$type]);

        return $this;
    }
}
