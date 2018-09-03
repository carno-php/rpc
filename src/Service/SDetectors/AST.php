<?php
/**
 * Service detecting via AST
 * User: moyo
 * Date: 24/02/2018
 * Time: 4:17 PM
 */

namespace Carno\RPC\Service\SDetectors;

use const ast\AST_CLASS;
use const ast\AST_NAME;
use const ast\AST_NAME_LIST;
use const ast\AST_USE;
use const ast\AST_STMT_LIST;
use const ast\flags\USE_NORMAL;
use function ast\parse_file;
use ast\Node;
use Carno\RPC\Service\Router;

class AST implements API
{
    use ASS;

    /**
     * @var array
     */
    private $psr4al = [];

    /**
     * @return bool
     */
    public function supported() : bool
    {
        return function_exists('ast\parse_file');
    }

    /**
     * @param Router $router
     * @param string $contracts
     * @param string $implementer
     */
    public function analyzing(Router $router, string $contracts, string $implementer) : void
    {
        if (is_file($f = $this->file($implementer))) {
            $tree = parse_file($f, $ver = 50);
            if ($tree->kind === AST_STMT_LIST) {
                $uses = [];
                /**
                 * @var Node $stmt
                 * @var Node $use
                 */
                foreach ($tree->children as $stmt) {
                    switch ($stmt->kind) {
                        case AST_USE:
                            $ifo = $stmt->children[0]->children;
                            $uses[$ifo['alias'] ?? array_slice(explode('\\', $ifo['name']), -1)[0]] = $ifo['name'];
                            break;
                        case AST_CLASS:
                            $imps = $stmt->children['implements'] ?? null;
                            if ($imps instanceof Node && $imps->kind === AST_NAME_LIST) {
                                foreach ($imps->children as $use) {
                                    if ($use->kind === AST_NAME && $use->flags === USE_NORMAL) {
                                        $this->assigning(
                                            $router,
                                            $contracts,
                                            array_slice(explode('\\', $uses[$use->children['name']] ?? ''), 0, -1)
                                        );
                                    }
                                }
                            }
                            break;
                    }
                }
            }
        }
    }

    /**
     * @param string $class
     * @return string
     */
    private function file(string $class) : string
    {
        return sprintf('%s/%s.php', $this->psr4base($class), str_replace('\\', '/', $class));
    }

    /**
     * @param string $class
     * @return string
     */
    private function psr4base(string &$class) : string
    {
        if (empty($this->psr4al)) {
            $this->psr4init();
        }

        $pts = explode('\\', $class);

        $map = $this->psr4al;

        while ($pts) {
            $got = $map[array_shift($pts)] ?? false;
            if (is_string($got)) {
                $class = implode('\\', $pts);
                return $got;
            } elseif (is_array($got)) {
                $map = $got;
            }
        }

        return '/';
    }

    /**
     */
    private function psr4init() : void
    {
        if (defined('CWD') && is_file($cj = CWD . '/composer.json')) {
            $conf = json_decode(file_get_contents($cj), true);
            foreach ($conf['autoload']['psr-4'] ?? [] as $nsp => $path) {
                $slot = &$this->psr4al;
                foreach (explode('\\', $nsp) as $part) {
                    $part && $slot = &$slot[$part];
                }
                $slot = sprintf('%s/%s', CWD, $path);
            }
        }
    }
}
