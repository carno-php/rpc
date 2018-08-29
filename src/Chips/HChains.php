<?php
/**
 * Handler chains
 * User: moyo
 * Date: 19/03/2018
 * Time: 11:24 AM
 */

namespace Carno\RPC\Chips;

use Carno\Chain\Layers;
use Carno\Container\DI;

trait HChains
{
    /**
     * @return Layers
     */
    final public static function layers() : Layers
    {
        return DI::has(self::class) ? DI::get(self::class) : DI::set(self::class, new Layers);
    }
}
