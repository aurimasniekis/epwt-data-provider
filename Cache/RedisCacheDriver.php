<?php

namespace EPWT\Cache\DataProviderBundle\Cache;

/**
 * Class RedisCacheDriver
 * @package EPWT\Cache\DataProviderBundle\Cache
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class RedisCacheDriver extends BaseCacheDriver
{
    /**
     * @var \Redis
     */
    protected $redis;
    /**
     * @return \Redis
     */
    public function getRedis()
    {
        return $this->redis;
    }

    /**
     * @param \Redis $redis
     *
     * @return $this
     */
    public function setRedis($redis)
    {
        $this->redis = $redis;

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $data
     * @param bool|int $ttl
     *
     * @return bool
     */
    public function set($key, $data, $ttl = false)
    {
        if ($ttl) {
            $result = $this->getRedis()->setex($key, (int) $ttl, $this->phpSerialize($data));
        } else {
            $result = $this->getRedis()->set($key, $this->phpSerialize($data));
        }

        $this->cachedValues[$key] = $data;

        return (bool) $result;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function exists($key)
    {
        if (isset($this->cachedValues[$key])) {
            return true;
        }

        return (bool) $this->getRedis()->exists($key);
    }

    /**
     * @param string $key
     *
     * @return bool|mixed
     */
    public function get($key)
    {
        if (isset($this->cachedValues[$key])) {
            return $this->cachedValues[$key];
        }

        $result = $this->getRedis()->get($key);

        return null === $result ? false : $this->phpDeserialize($result);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete($key)
    {
        if (is_string($key)) {
            unset($this->cachedValues[$key]);
        }

        return (bool) $this->getRedis()->del($key);
    }
}
