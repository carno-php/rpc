<?php
/**
 * Errors initializer
 * User: moyo
 * Date: 19/01/2018
 * Time: 5:53 PM
 */

namespace Carno\RPC\Chips;

trait ErrorsInit
{
    /**
     * ErrorsInit constructor.
     * @param int $code
     * @param string $message
     */
    public function __construct(int $code, string $message = '')
    {
        parent::__construct($message, $code);
    }
}
