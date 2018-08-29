<?php
/**
 * Service invoker
 * User: moyo
 * Date: 25/09/2017
 * Time: 4:57 PM
 */

namespace Carno\RPC\Handlers;

use Carno\Chain\Layered;
use function Carno\Coroutine\async;
use Carno\Coroutine\Context;
use function Carno\Coroutine\race;
use function Carno\Coroutine\timeout;
use Carno\Promise\Promised;
use Carno\RPC\Service\Dispatcher;
use Carno\RPC\Protocol\Request;
use Carno\RPC\Protocol\Response;
use Throwable;

class ServiceInvoker implements Layered
{
    /**
     * @var Dispatcher
     */
    private $dispatcher = null;

    /**
     * ServiceInvoker constructor.
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Request $request
     * @param Context $ctx
     * @return Promised
     */
    public function inbound($request, Context $ctx) : Promised
    {
        return race(async(function ($request) {
            return $this->dispatcher->invoke($request);
        }, $ctx, $request), timeout(5000));
    }

    /**
     * @param Response $response
     * @param Context $ctx
     * @return Response
     */
    public function outbound($response, Context $ctx) : Response
    {
        return $response;
    }

    /**
     * @param Throwable $e
     * @param Context $ctx
     * @return void
     * @throws Throwable
     */
    public function exception(Throwable $e, Context $ctx) : void
    {
        throw $e;
    }
}
