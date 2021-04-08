<?php

declare (strict_types=1);
namespace Rector\Core\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use Rector\Core\Util\StaticNodeInstanceOf;
use Rector\NodeNameResolver\NodeNameResolver;
use RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class ClassMethodPropertyFetchManipulator
{
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\RectorPrefix20210408\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * In case the property name is different to param name:
     *
     * E.g.:
     * (SomeType $anotherValue)
     * $this->value = $anotherValue;
     * ↓
     * (SomeType $anotherValue)
     */
    public function resolveParamForPropertyFetch(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $propertyName) : ?\PhpParser\Node\Param
    {
        $assignedParamName = null;
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) use($propertyName, &$assignedParamName) : ?int {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->nodeNameResolver->isName($node->var, $propertyName)) {
                return null;
            }
            if (\Rector\Core\Util\StaticNodeInstanceOf::isOneOf($node->expr, [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class])) {
                return null;
            }
            $assignedParamName = $this->nodeNameResolver->getName($node->expr);
            return \PhpParser\NodeTraverser::STOP_TRAVERSAL;
        });
        /** @var string|null $assignedParamName */
        if ($assignedParamName === null) {
            return null;
        }
        /** @var Param $param */
        foreach ($classMethod->params as $param) {
            if (!$this->nodeNameResolver->isName($param, $assignedParamName)) {
                continue;
            }
            return $param;
        }
        return null;
    }
}
