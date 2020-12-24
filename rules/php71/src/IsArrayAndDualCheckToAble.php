<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Instanceof_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function processBooleanOr(\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanOr $booleanOr, string $type, string $newMethodName) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($booleanOr, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Instanceof_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class);
        if ($twoNodeMatch === null) {
            return null;
        }
        /** @var Instanceof_ $instanceOfNode */
        $instanceOfNode = $twoNodeMatch->getFirstExpr();
        /** @var FuncCall $funcCallNode */
        $funcCallNode = $twoNodeMatch->getSecondExpr();
        $instanceOfClass = $instanceOfNode->class;
        if ($instanceOfClass instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
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
        if (!$funcCallNode->args[0]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var Variable $firstVarNode */
        $firstVarNode = $funcCallNode->args[0]->value;
        if (!$instanceOfNode->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var Variable $secondVarNode */
        $secondVarNode = $instanceOfNode->expr;
        // are they same variables
        if ($firstVarNode->name !== $secondVarNode->name) {
            return null;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name($newMethodName), [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($firstVarNode)]);
    }
}
