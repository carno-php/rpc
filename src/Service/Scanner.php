<?php
/**
 * Service scanner
 * User: moyo
 * Date: 20/09/2017
 * Time: 4:12 PM
 */

namespace Carno\RPC\Service;

use Carno\RPC\Exception\IllegalServiceMethodDependsException;
use Carno\RPC\Exception\IllegalServiceMethodParamsException;
use Carno\RPC\Service\SDetectors\API;
use Carno\RPC\Service\SDetectors\AST;
use Carno\RPC\Service\SDetectors\REF;
use ReflectionClass;
use ReflectionMethod;

class Scanner
{
    /**
     * name of "contracts" for interfaces
     */
    public const CONTRACTS_NAME = 'contracts';

    /**
     * name of "clients" for rpc client
     */
    public const CLIENTS_NAME = 'clients';

    /**
     * base class of pb message/struct
     */
    private const PB_STRUCT_BASE = 'Google\\Protobuf\\Internal\\Message';

    /**
     * @var string[]
     */
    private $services = [];

    /**
     * @var Router
     */
    private $router = null;

    /**
     * @var API
     */
    private $detector = null;

    /**
     * @var string[]
     */
    private $detectors = [AST::class, REF::class];

    /**
     * Scanner constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;

        /**
         * @var API $api
         */
        foreach ($this->detectors as $detector) {
            $api = new $detector;
            if ($api->supported()) {
                $this->detector = $api;
                break;
            }
        }
    }

    /**
     * @param string ...$services
     * @return static
     */
    public function sources(string ...$services) : self
    {
        $this->services = array_unique(array_merge($this->services, $services));
        return $this;
    }

    /**
     */
    public function serving() : void
    {
        array_walk($this->services, function (string $implementer) {
            $this->detector->analyzing($this->router, self::CONTRACTS_NAME, $implementer);
        });
    }

    /**
     */
    public function analyzing() : void
    {
        array_walk($this->services, function (string $implementer) {
            $ref = new ReflectionClass($implementer);

            foreach ($ref->getInterfaces() as $inf) {
                $nss = array_map(static function ($p) {
                    return lcfirst($p);
                }, explode('\\', $inf->getNamespaceName()));

                if (array_pop($nss) === self::CONTRACTS_NAME) {
                    $this->router->add(
                        (new Specification(implode('.', $nss), $inf->getShortName()))
                            ->setMethods($this->analyzeMethods(...$inf->getMethods(ReflectionMethod::IS_PUBLIC))),
                        $implementer
                    );
                }
            }
        });
    }

    /**
     * @param ReflectionMethod ...$methods
     * @return array
     */
    private function analyzeMethods(ReflectionMethod ...$methods) : array
    {
        $analyzed = [];

        foreach ($methods as $method) {
            $name = $method->getName();
            $params = $method->getParameters();

            foreach ($params as $param) {
                $class = $param->getClass();
                if (is_null($class)) {
                    throw new IllegalServiceMethodParamsException(
                        "#{$param->getPosition()} Expect CLASS but found [{$param->getType()->getName()}]"
                    );
                } else {
                    $this->assertPBMessage($class->getName());
                    $analyzed[$name] = ['in' => $class->getName()];
                }
            }
        }

        return $analyzed;
    }

    /**
     * @param string $class
     */
    private function assertPBMessage(string $class) : void
    {
        $parent = (new ReflectionClass($class))->getParentClass();
        if (empty($parent) || $parent->getName() !== self::PB_STRUCT_BASE) {
            throw new IllegalServiceMethodDependsException(
                "Provided class is not inherit from pb message"
            );
        }
    }
}
