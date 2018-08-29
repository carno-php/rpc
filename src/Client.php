<?php
/**
 * RPC client base
 * User: moyo
 * Date: 27/09/2017
 * Time: 6:14 PM
 */

namespace Carno\RPC;

use function Carno\Coroutine\ctx;
use Carno\RPC\Chips\HChains;
use Carno\RPC\Chips\NamedKit;
use Carno\RPC\Contracts\Client\Cluster;
use Carno\RPC\Contracts\Client\Remapping;
use Carno\RPC\Exception\ClientInitializingException;
use Carno\RPC\Protocol\Request;
use Carno\RPC\Protocol\Response;
use Google\Protobuf\Internal\Message;
use Closure;

abstract class Client
{
    use NamedKit, HChains;

    /**
     * @var Closure
     */
    private $invoker = null;

    /**
     * Client constructor.
     * @param Cluster $clustering
     * @param Remapping $remapping
     */
    final public function __construct(Cluster $clustering = null, Remapping $remapping = null)
    {
        $serv = $this->namedServer(static::class);

        if ($remapping && $remapping->configured($serv)) {
            $this->invoker = $remapping->dispatcher()->handler();
        } elseif ($clustering) {
            $clustering->joining($serv);
            $this->invoker = Client::layers()->handler();
        } else {
            throw new ClientInitializingException;
        }
    }

    /**
     * @param string $server
     * @param string $service
     * @param string $method
     * @param Message $request
     * @param Message $response
     * @return Message
     */
    final protected function request(
        string $server,
        string $service,
        string $method,
        Message $request,
        Message $response
    ) {
        $rpc =
            (new Request($server, $service, $method))
                ->setJsonc(false)
                ->setPayload($request->serializeToString())
        ;

        /**
         * @var Response $resp
         */
        $resp = yield ($this->invoker)($rpc, clone yield ctx());

        $response->mergeFromString($resp->getPayload());

        return $response;
    }
}
