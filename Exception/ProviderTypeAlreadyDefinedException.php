<?php

namespace EPWT\Cache\DataProviderBundle\Exception;

use Exception;

/**
 * Class ProviderTypeAlreadyDefinedException
 * @package EPWT\Cache\DataProviderBundle\Exception
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class ProviderTypeAlreadyDefinedException extends \Exception
{
    public function __construct($type)
    {
        $message = sprintf(
            'Provider Type "%s" already defined',
            $type
        );

        parent::__construct($message);
    }
}
