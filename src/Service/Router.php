<?php
/**
 * Services router (named service -> implemented class)
 * User: moyo
 * Date: 20/09/2017
 * Time: 4:09 PM
 */

namespace Carno\RPC\Service;

use Carno\RPC\Chips\RTServer;

class Router
{
    use RTServer;

    /**
     * @var array
     */
    private $servers = [];

    /**
     * @var array
     */
    private $invokers = [];

    /**
     * @param Specification $service
     * @param string $implementer
     * @return static
     */
    public function add(Specification $service, string $implementer) : self
    {
        $this->invokers[$service->getServer()][$service->getService()] = [$service, $implementer];
        return $this;
    }

    /**
     * [Specification,implementer]
     * @param string $server
     * @param string $service
     * @return array
     */
    public function get(string $server, string $service) : array
    {
        return $this->invokers[$server][$service] ?? [];
    }

    /**
     * @param string $server
     * @return static
     */
    public function serving(string $server) : self
    {
        $this->servers = array_unique(array_merge($this->servers, [$server]));
        return $this;
    }

    /**
     * get all implemented servers
     * @return array
     */
    public function servers() : array
    {
        return $this->servers;
    }

    /**
     * [[Specification,implementer]]
     * @param string $server
     * @return array
     */
    public function services(string $server) : array
    {
        return $this->invokers[$server] ?? [];
    }
}
