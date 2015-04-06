<?php

namespace EPWT\Cache\DataProviderBundle\Cache;

/**
 * Interface CacheDriverInterface
 * @package EPWT\Cache\DataProviderBundle\Cache
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
interface CacheDriverInterface
{
    /**
     * @param string $key
     * @param mixed $data
     * @param bool|int $ttl
     *
     * @return bool
     */
    public function set($key, $data, $ttl = false);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function exists($key);

    /**
     * @param string $key
     *
     * @return bool|mixed
     */
    public function get($key);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete($key);
}

