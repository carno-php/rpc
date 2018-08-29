<?php
/**
 * Instances preparer
 * User: moyo
 * Date: 18/10/2017
 * Time: 2:45 PM
 */

namespace Carno\RPC\Chips;

use Carno\Container\DI;
use function Carno\Coroutine\all;
use Carno\Promise\Promised;
use Carno\RPC\Contracts\Server\Lifecycle;
use Carno\RPC\Service\Router;

trait DInstances
{
    /**
     * @return Router
     */
    private function dr() : Router
    {
        return $this->router;
    }

    /**
     * bind service implementer
     * @param Promised $started
     * @param Promised $stopping
     * @return Promised
     */
    public function preparing(Promised $started, Promised $stopping) : Promised
    {
        $starts = [];

        foreach ($this->dr()->servers() as $api) {
            foreach ($this->dr()->services($api) as $service => $route) {
                // set global instance of service
                DI::set($class = $route[1], $server = DI::object($class));
                // lifecycle hooks
                if ($server instanceof Lifecycle) {
                    $starts[] = $started->then([$server, 'started']);
                    $stopping->then([$server, 'stopped']);
                }
            }
        }

        return all(...$starts);
    }
}
