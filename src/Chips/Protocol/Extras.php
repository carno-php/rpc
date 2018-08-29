<?php
/**
 * Extras information
 * User: moyo
 * Date: 12/12/2017
 * Time: 12:05 PM
 */

namespace Carno\RPC\Chips\Protocol;

use Closure;

trait Extras
{
    /**
     * @var array
     */
    private $extras = [];

    /**
     * @param string $key
     * @return bool
     */
    public function hasExtra(string $key) : bool
    {
        return isset($this->extras[$key]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getExtra(string $key)
    {
        return $this->extras[$key] ?? null;
    }

    /**
     * @param string $key
     * @param mixed $val
     * @return static
     */
    public function setExtra(string $key, $val) : self
    {
        $this->extras[$key] = $val;
        return $this;
    }

    /**
     * @param string $key
     * @param Closure $setter
     */
    public function opsExtra(string $key, Closure $setter) : void
    {
        isset($this->extras[$key]) || $this->extras[$key] = [];
        $setter($this->extras[$key]);
    }
}
