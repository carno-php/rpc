<?php
/**
 * Service specification
 * User: moyo
 * Date: 21/09/2017
 * Time: 10:50 AM
 */

namespace Carno\RPC\Service;

class Specification
{
    /**
     * @var string
     */
    private $server = null;

    /**
     * @var string
     */
    private $service = null;

    /**
     * @var array
     */
    private $methodRequests = [];

    /**
     * @var array
     */
    private $methodResponses = [];

    /**
     * Specification constructor.
     * @param string $server
     * @param string $service
     */
    public function __construct(string $server, string $service)
    {
        $this->server = $server;
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getServer() : string
    {
        return $this->server;
    }

    /**
     * @return string
     */
    public function getService() : string
    {
        return $this->service;
    }

    /**
     * @param array $methodRRs
     * @return static
     */
    public function setMethods(array $methodRRs) : self
    {
        foreach ($methodRRs as $methodName => $rrs) {
            isset($rrs['in']) && $this->methodRequests[$methodName] = $rrs['in'];
            isset($rrs['out']) && $this->methodResponses[$methodName] = $rrs['out'];
        }
        return $this;
    }

    /**
     * @param string $method
     * @return string
     */
    public function getMethodRequest(string $method) : string
    {
        return $this->methodRequests[$method] ?? '';
    }

    /**
     * @param string $method
     * @return string
     */
    public function getMethodResponse(string $method) : string
    {
        return $this->methodResponses[$method] ?? '';
    }
}
