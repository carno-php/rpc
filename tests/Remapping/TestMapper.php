<?php
/**
 * Test mapper
 * User: moyo
 * Date: 2019-04-03
 * Time: 13:45
 */

namespace Carno\RPC\Tests\Remapping;

use Carno\Chain\Layers;
use Carno\Container\DI;
use Carno\RPC\Contracts\Client\Remapping;
use Carno\RPC\Handlers\ServiceInvoker;
use Carno\RPC\Service\Dispatcher;
use Carno\RPC\Service\Instances;
use Carno\RPC\Service\Router;
use Carno\RPC\Service\Specification;
use Carno\Tests\Hello\Payload;

class TestMapper implements Remapping
{
    public function configured(string $server) : bool
    {
        return true;
    }

    public function dispatcher() : Layers
    {
        $router = new Router;
        $instances = new Instances;

        $router->add(
            (new Specification('ns.g.s', 'serv'))
                ->setMethods(['rpc' => ['in' => Payload::class]]),
            RpcInstance::class
        );

        $instances->set(RpcInstance::class, RpcInstance::class);

        return new Layers(
            DI::object(
                ServiceInvoker::class,
                DI::object(Dispatcher::class, $router, $instances)
            )
        );
    }
}
