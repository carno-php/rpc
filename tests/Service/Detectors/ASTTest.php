<?php
/**
 * AST detector test
 * User: moyo
 * Date: 2018/11/5
 * Time: 11:23 AM
 */

namespace Carno\RPC\Tests\Service\Detectors;

use Carno\RPC\Service\Router;
use Carno\RPC\Service\SDetectors\AST;
use Carno\RPC\Tests\Mocked\Services\Test1;
use Carno\RPC\Tests\Mocked\Services\Test2;
use PHPUnit\Framework\TestCase;

class ASTTest extends TestCase
{
    public function testParse1()
    {
        (new AST)->supported() || $this->markTestSkipped('Not supported');

        $this->assertClass(Test1::class, 'mocked.app.tests');
        $this->assertClass(Test2::class, 'mocked.app.tests');
    }

    private function assertClass(string $class, string $named)
    {
        (new AST)->analyzing($router = new Router, 'contracts', $class);
        $this->assertEquals($named, $router->server());
    }
}
