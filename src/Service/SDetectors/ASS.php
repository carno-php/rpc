<?php
/**
 * Service serving assigner
 * User: moyo
 * Date: 24/02/2018
 * Time: 6:16 PM
 */

namespace Carno\RPC\Service\SDetectors;

use Carno\RPC\Service\Router;

trait ASS
{
    /**
     * @param Router $router
     * @param string $contracts
     * @param array $namespaces
     * @return bool
     */
    protected function assigning(Router $router, string $contracts, array $namespaces) : bool
    {
        $nss = array_map(static function ($p) {
            return lcfirst($p);
        }, $namespaces);

        if (array_pop($nss) === $contracts) {
            $router->serving(implode('.', $nss));
            return true;
        }

        return false;
    }
}
