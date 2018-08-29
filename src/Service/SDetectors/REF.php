<?php
/**
 * Service detecting via reflection
 * User: moyo
 * Date: 24/02/2018
 * Time: 4:16 PM
 */

namespace Carno\RPC\Service\SDetectors;

use Carno\RPC\Service\Router;
use ReflectionClass;

class REF implements API
{
    use ASS;

    /**
     * @return bool
     */
    public function supported() : bool
    {
        return true;
    }

    /**
     * @param Router $router
     * @param string $contracts
     * @param string $implementer
     */
    public function analyzing(Router $router, string $contracts, string $implementer) : void
    {
        foreach ((new ReflectionClass($implementer))->getInterfaces() as $inf) {
            $this->assigning($router, $contracts, explode('\\', $inf->getNamespaceName()));
        }
    }
}
