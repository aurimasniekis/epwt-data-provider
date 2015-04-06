<?php

namespace EPWT\Cache\DataProviderBundle\Exception;

/**
 * Class CacheDriverNotFoundException
 * @package EPWT\Cache\DataProviderBundle\Exception
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class CacheDriverNotFoundException extends \Exception
{
    public function __construct($driverName)
    {
        $message = sprintf(
            'Cache Driver "%s" not found',
            $driverName
        );

        parent::__construct($message);
    }
}
