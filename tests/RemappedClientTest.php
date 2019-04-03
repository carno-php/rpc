<?php
/**
 * Remapped client test
 * User: moyo
 * Date: 2019-04-03
 * Time: 13:44
 */

namespace Carno\RPC\Tests;

use function Carno\Coroutine\go;
use Carno\RPC\Tests\Remapping\TestClient;
use Carno\RPC\Tests\Remapping\TestMapper;
use Carno\Tests\Hello\Payload;
use PHPUnit\Framework\TestCase;

class RemappedClientTest extends TestCase
{
    public function testInvoke()
    {
        go(function () {
            /**
             * @var Payload $resp
             */

            $client = new TestClient(null, new TestMapper);

            $resp = yield $client->invoke($in = uniqid());

            $this->assertEquals($in, $resp->getData());
        });
    }
}
