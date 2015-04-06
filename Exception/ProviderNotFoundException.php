<?php

namespace EPWT\Cache\DataProviderBundle\Exception;

/**
 * Class ProviderNotFoundException
 * @package EPWT\Cache\DataProviderBundle\Exception
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class ProviderNotFoundException extends \Exception
{
    public function __construct($type)
    {
        $message = sprintf(
            'Provider "%s" not found',
            $type
        );

        parent::__construct($type);
    }
}
