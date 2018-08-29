<?php
/**
 * Service dispatcher
 * User: moyo
 * Date: 20/09/2017
 * Time: 4:13 PM
 */

namespace Carno\RPC\Service;

use Carno\RPC\Chips\DInstances;
use Carno\RPC\Exception\InvalidExecutingResultException;
use Carno\RPC\Exception\RequestMethodNotFoundException;
use Carno\RPC\Exception\RequestServiceNotFoundException;
use Carno\RPC\Protocol\Request;
use Carno\RPC\Protocol\Response;
use Google\Protobuf\Internal\Message;

class Dispatcher
{
    use DInstances;

    /**
     * @var Router
     */
    private $router = null;

    /**
     * @var Instances
     */
    private $instances = null;

    /**
     * Dispatcher constructor.
     * @param Router $router
     * @param Instances $instances
     */
    public function __construct(Router $router, Instances $instances)
    {
        $this->router = $router;
        $this->instances = $instances;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function invoke(Request $request)
    {
        if (empty($route = $this->router->get($request->server(), $request->service()))) {
            throw new RequestServiceNotFoundException("{$request->server()}.{$request->service()}");
        }

        /**
         * @var Specification $spec
         * @var string $impl
         */
        list($spec, $impl) = $route;

        if (empty($requestC = $spec->getMethodRequest($request->method()))) {
            throw new RequestMethodNotFoundException($request->method());
        }

        $program = $this->instances->get($impl);
        $method = $request->method();

        $result = yield $program->$method($request->struct(new $requestC));

        if ($result instanceof Message) {
            return new Response($request, $result);
        } else {
            throw new InvalidExecutingResultException;
        }
    }
}
