<?php
/**
 * T Response
 * User: moyo
 * Date: 22/09/2017
 * Time: 12:54 PM
 */

namespace Carno\RPC\Protocol;

use Carno\RPC\Chips\Protocol\Jsonc;
use Carno\RPC\Chips\Protocol\Payload;
use Google\Protobuf\Internal\Message;

class Response
{
    use Jsonc, Payload;

    /**
     * Response constructor.
     * @param Request $request
     * @param Message|string $result
     */
    public function __construct(Request $request, $result)
    {
        $this->setJsonc($request->isJsonc());

        $result instanceof Message
            ? $this->setPayload($this->isJsonc() ? $result->serializeToJsonString() : $result->serializeToString())
            : $this->setPayload($result)
        ;
    }
}
