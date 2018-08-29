<?php
/**
 * T Request
 * User: moyo
 * Date: 22/09/2017
 * Time: 12:36 PM
 */

namespace Carno\RPC\Protocol;

use Carno\RPC\Chips\Protocol\Extras;
use Carno\RPC\Chips\Protocol\Jsonc;
use Carno\RPC\Chips\Protocol\Payload;
use Carno\RPC\Chips\Protocol\Tags;
use Google\Protobuf\Internal\Message;

class Request
{
    use Jsonc, Payload, Tags, Extras;

    /**
     * @var string
     */
    private $server = null;

    /**
     * @var string
     */
    private $service = null;

    /**
     * @var string
     */
    private $method = null;

    /**
     * Request constructor.
     * @param string $server
     * @param string $service
     * @param string $method
     */
    public function __construct(string $server, string $service, string $method)
    {
        $this->server = $server;
        $this->service = $service;
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function identify() : string
    {
        return "{$this->server()}.{$this->service()}.{$this->method()}";
    }

    /**
     * @return string
     */
    public function server() : string
    {
        return $this->server;
    }

    /**
     * @return string
     */
    public function service() : string
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function method() : string
    {
        return $this->method;
    }

    /**
     * @param Message $input
     * @return Message
     */
    public function struct(Message $input) : Message
    {
        $this->isJsonc()
            ? $input->mergeFromJsonString($this->getPayload())
            : $input->mergeFromString($this->getPayload())
        ;

        return $input;
    }
}
