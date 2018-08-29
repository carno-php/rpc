<?php
/**
 * Remote logic exception
 * User: moyo
 * Date: 17/01/2018
 * Time: 2:32 PM
 */

namespace Carno\RPC\Exception;

use Carno\RPC\Chips\ErrorsInit;
use Carno\RPC\Errors\GenericError;

class RemoteLogicException extends GenericError
{
    use ErrorsInit;
}
