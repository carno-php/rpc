<?php
/**
 * Service detector API
 * User: moyo
 * Date: 24/02/2018
 * Time: 4:19 PM
 */

namespace Carno\RPC\Service\SDetectors;

use Carno\RPC\Service\Router;

interface API
{
    /**
     * @return bool
     */
    public function supported() : bool;

    /**
     * @param Router $router
     * @param string $contracts
     * @param string $implementer
     */
    public function analyzing(Router $router, string $contracts, string $implementer) : void;
}
