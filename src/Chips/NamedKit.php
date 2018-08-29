<?php
/**
 * Named kit
 * User: moyo
 * Date: 30/10/2017
 * Time: 10:51 AM
 */

namespace Carno\RPC\Chips;

use Carno\RPC\Service\Scanner;

trait NamedKit
{
    /**
     * @param string $class
     * @return string
     */
    private function namedServer(string $class) : string
    {
        $segments = array_map(static function ($p) {
            return lcfirst($p);
        }, explode('\\', $class));

        while ($segments) {
            if (Scanner::CLIENTS_NAME === $pop = array_pop($segments)) {
                break;
            }
        }

        return implode('.', $segments);
    }
}
