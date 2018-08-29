<?php
/**
 * Payload operates
 * User: moyo
 * Date: 23/10/2017
 * Time: 10:35 AM
 */

namespace Carno\RPC\Chips\Protocol;

trait Payload
{
    /**
     * @var string
     */
    private $payload = null;

    /**
     * @param string $data
     * @return static
     */
    public function setPayload(string $data) : self
    {
        $this->payload = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayload() : string
    {
        return $this->payload;
    }
}
