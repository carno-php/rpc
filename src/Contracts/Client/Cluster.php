<?php
/**
 * Service cluster
 * User: moyo
 * Date: 11/10/2017
 * Time: 11:52 AM
 */

namespace Carno\RPC\Contracts\Client;

interface Cluster
{
    /**
     * @return string[]
     */
    public function tags() : array;

    /**
     * @param string $server
     */
    public function joining(string $server) : void;

    /**
     * @param string $server
     * @param string ...$tags
     * @return object
     */
    public function picking(string $server, string ...$tags) : object;
}
