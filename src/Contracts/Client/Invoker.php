<?php
/**
 * Service invoke (client side)
 * User: moyo
 * Date: 11/10/2017
 * Time: 11:49 AM
 */

namespace Carno\RPC\Contracts\Client;

use Carno\Chain\Layered;
use Carno\RPC\Protocol\Request;
use Carno\RPC\Protocol\Response;

interface Invoker extends Layered
{
    /**
     * @param Request $request
     * @return Response
     */
    public function call(Request $request);
}
