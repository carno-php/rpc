<?php
/**
 * Service instances
 * User: moyo
 * Date: 26/09/2017
 * Time: 4:14 PM
 */

namespace Carno\RPC\Service;

use Carno\Container\DI;
use Carno\RPC\Exception\ServiceInstanceNotFoundException;

class Instances
{
    /**
     * @param string $class
     * @return object
     */
    public function get(string $class) : object
    {
        if (DI::has($class)) {
            return DI::get($class);
        } else {
            throw new ServiceInstanceNotFoundException($class);
        }
    }
}
