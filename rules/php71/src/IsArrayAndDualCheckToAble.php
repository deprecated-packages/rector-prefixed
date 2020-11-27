<?php

declare (strict_types=1);
namespace Rector\Php71;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use Rector\NodeNameResolver\NodeNameResolver;
final class IsArrayAndDualCheckToAble
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BinaryOpManipulator
     */
    private $binaryOpManipulator;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function processBooleanOr(\PhpParser\Node\Expr\BinaryOp\BooleanOr $booleanOr, string $type, string $newMethodName) : ?\PhpParser\Node\Expr\FuncCall
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($booleanOr, \PhpParser\Node\Expr\Instanceof_::class, \PhpParser\Node\Expr\FuncCall::class);
        if ($twoNodeMatch === null) {
            return null;
        }
        /** @var Instanceof_ $instanceOfNode */
        $instanceOfNode = $twoNodeMatch->getFirstExpr();
        /** @var FuncCall $funcCallNode */
        $funcCallNode = $twoNodeMatch->getSecondExpr();
        $instanceOfClass = $instanceOfNode->class;
        if ($instanceOfClass instanceof \PhpParser\Node\Expr) {
            return null;
        }
        if ((string) $instanceOfClass !== $type) {
            return null;
        }
        $nodeNameResolverGetName = $this->nodeNameResolver->getName($funcCallNode);
        /** @var FuncCall $funcCallNode */
        if ($nodeNameResolverGetName !== 'is_array') {
            return null;
        }
        // both use same var
        if (!$funcCallNode->args[0]->value instanceof \PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var Variable $firstVarNode */
        $firstVarNode = $funcCallNode->args[0]->value;
        if (!$instanceOfNode->expr instanceof \PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var Variable $secondVarNode */
        $secondVarNode = $instanceOfNode->expr;
        // are they same variables
        if ($firstVarNode->name !== $secondVarNode->name) {
            return null;
        }
        return new \PhpParser\Node\Expr\FuncCall(new \PhpParser\Node\Name($newMethodName), [new \PhpParser\Node\Arg($firstVarNode)]);
    }
}
