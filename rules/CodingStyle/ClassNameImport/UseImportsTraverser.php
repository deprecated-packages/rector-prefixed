<?php

declare (strict_types=1);
namespace Rector\CodingStyle\ClassNameImport;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\GroupUse;
use PhpParser\Node\Stmt\Use_;
use Rector\NodeNameResolver\NodeNameResolver;
use RectorPrefix20210422\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class UseImportsTraverser
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    public function __construct(\RectorPrefix20210422\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
    }
    /**
     * @param Stmt[] $stmts
     * @return void
     */
    public function traverserStmtsForFunctions(array $stmts, callable $callable)
    {
        $this->traverseForType($stmts, $callable, \PhpParser\Node\Stmt\Use_::TYPE_FUNCTION);
    }
    /**
     * @param Stmt[] $stmts
     * @return void
     */
    public function traverserStmts(array $stmts, callable $callable)
    {
        $this->traverseForType($stmts, $callable, \PhpParser\Node\Stmt\Use_::TYPE_NORMAL);
    }
    /**
     * @param Stmt[] $stmts
     * @return void
     */
    private function traverseForType(array $stmts, callable $callable, int $desiredType)
    {
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($stmts, function (\PhpParser\Node $node) use($callable, $desiredType) {
            if ($node instanceof \PhpParser\Node\Stmt\Use_) {
                // only import uses
                if ($node->type !== $desiredType) {
                    return null;
                }
                foreach ($node->uses as $useUse) {
                    $name = $this->nodeNameResolver->getName($useUse);
                    $callable($useUse, $name);
                }
            }
            if ($node instanceof \PhpParser\Node\Stmt\GroupUse) {
                $this->processGroupUse($node, $desiredType, $callable);
            }
            return null;
        });
    }
    /**
     * @return void
     */
    private function processGroupUse(\PhpParser\Node\Stmt\GroupUse $groupUse, int $desiredType, callable $callable)
    {
        if ($groupUse->type !== \PhpParser\Node\Stmt\Use_::TYPE_UNKNOWN) {
            return;
        }
        $prefixName = $groupUse->prefix->toString();
        foreach ($groupUse->uses as $useUse) {
            if ($useUse->type !== $desiredType) {
                continue;
            }
            $name = $prefixName . '\\' . $this->nodeNameResolver->getName($useUse);
            $callable($useUse, $name);
        }
    }
}
