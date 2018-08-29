<?php
/**
 * Json encoding
 * User: moyo
 * Date: 23/10/2017
 * Time: 10:35 AM
 */

namespace Carno\RPC\Chips\Protocol;

trait Jsonc
{
    /**
     * @var bool
     */
    private $jsonc = false;

    /**
     * @return bool
     */
    public function isJsonc() : bool
    {
        return $this->jsonc;
    }

    /**
     * @param bool $switch
     * @return static
     */
    public function setJsonc(bool $switch = true) : self
    {
        $this->jsonc = $switch;
        return $this;
    }
}
