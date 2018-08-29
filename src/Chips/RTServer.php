<?php
/**
 * Runtime server (detecting)
 * User: moyo
 * Date: 18/10/2017
 * Time: 2:42 PM
 */

namespace Carno\RPC\Chips;

use Carno\RPC\Exception\ConfusedRuntimeServerException;
use Carno\RPC\Exception\UnknownRuntimeServerException;

trait RTServer
{
    /**
     * @var string
     */
    private $server = null;

    /**
     * @return string
     */
    public function server() : string
    {
        if ($this->server) {
            return $this->server;
        }

        switch (count($servers = $this->servers())) {
            case 0:
                throw new UnknownRuntimeServerException;
            case 1:
                return $this->server = current($servers);
            default:
                throw new ConfusedRuntimeServerException;
        }
    }
}
