<?php
/**
 * RPC client test
 * User: moyo
 * Date: 2019-04-03
 * Time: 13:43
 */

namespace Carno\RPC\Tests\Remapping;

use Carno\RPC\Client;
use Carno\Tests\Hello\Payload;

class TestClient extends Client
{
    public function invoke(string $dat)
    {
        return $this->request('ns.g.s', 'serv', 'rpc', (new Payload)->setData($dat), new Payload);
    }
}
