<?php
/**
 * Remote system exception
 * User: moyo
 * Date: 17/01/2018
 * Time: 2:21 PM
 */

namespace Carno\RPC\Exception;

use Carno\RPC\Chips\ErrorsInit;
use Carno\RPC\Errors\SystemError;

class RemoteSystemException extends SystemError
{
    use ErrorsInit;
}
