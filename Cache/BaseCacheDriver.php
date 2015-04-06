<?php

namespace EPWT\Cache\DataProviderBundle\Cache;

/**
 * Class BaseCacheDriver
 * @package EPWT\Cache\DataProviderBundle\Cache
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
abstract class BaseCacheDriver implements CacheDriverInterface
{
    /**
     * @var array
     */
    protected $cachedValues;

    public function __construct()
    {
        $this->cachedValues = [];
    }

    protected function phpSerialize($data)
    {
        if (function_exists('igbinary_serialize')) {
            return igbinary_serialize($data);
        }

        return serialize($data);
    }

    protected function phpDeserialize($data)
    {
        if (function_exists('igbinary_unserialize')) {
            return igbinary_unserialize($data);
        }

        return unserialize($data);
    }
}
