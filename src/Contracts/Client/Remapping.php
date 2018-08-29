<?php
/**
 * Service route remapping
 * User: moyo
 * Date: 2018/5/17
 * Time: 10:24 AM
 */

namespace Carno\RPC\Contracts\Client;

use Carno\Chain\Layers;

interface Remapping
{
    /**
     * @param string $server
     * @return bool
     */
    public function configured(string $server) : bool;

    /**
     * @return Layers
     */
    public function dispatcher() : Layers;
}
