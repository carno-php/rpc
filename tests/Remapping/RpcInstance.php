<?php
/**
 * Rpc instance mock
 * User: moyo
 * Date: 2019-04-03
 * Time: 14:13
 */

namespace Carno\RPC\Tests\Remapping;

use Carno\Tests\Hello\Payload;

class RpcInstance
{
    public function rpc(Payload $dat)
    {
        return $dat;
    }
}
