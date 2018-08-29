<?php
/**
 * Tags assign
 * User: moyo
 * Date: 2018/4/20
 * Time: 4:05 PM
 */

namespace Carno\RPC\Chips\Protocol;

trait Tags
{
    /**
     * @var array
     */
    private $tags = [];

    /**
     * @return bool
     */
    public function hasTags() : bool
    {
        return ! empty($this->tags);
    }

    /**
     * @return array
     */
    public function getTags() : array
    {
        return $this->tags;
    }

    /**
     * @param string ...$tags
     * @return static
     */
    public function setTags(string ...$tags) : self
    {
        $this->tags = $tags;
        return $this;
    }
}
