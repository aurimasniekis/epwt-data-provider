<?php

namespace EPWT\Cache\DataProviderBundle\Core;

interface ProviderInterface
{
    /**
     * Builds key for cache by data given to it
     *
     * @return string
     */
    public function buildKey();

    /**
     * @return int
     */
    public function getTTL();

    /**
     * Warm ups the cache by caching every row in table
     *
     * @return bool
     */
    public function warmUp();
}
