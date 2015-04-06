<?php

namespace EPWT\Cache\DataProviderBundle\Exception;

use Exception;

/**
 * Class ProviderTypeNotFoundException
 * @package EPWT\Cache\DataProviderBundle\Exception
 * @author Aurimas Niekis <aurimas.niekis@gmail.com>
 */
class ProviderTypeNotFoundException extends \Exception
{
    public function __construct($type)
    {
        $message = sprintf(
            'Provider Type "%s" not found',
            $type
        );

        parent::__construct($type);
    }
}
