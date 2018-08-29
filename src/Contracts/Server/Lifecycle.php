<?php
/**
 * Server lifecycle
 * User: moyo
 * Date: 06/12/2017
 * Time: 10:17 AM
 */

namespace Carno\RPC\Contracts\Server;

interface Lifecycle
{
    /**
     * RPC service started
     */
    public function started() : void;

    /**
     * RPC service stopped
     */
    public function stopped() : void;
}
