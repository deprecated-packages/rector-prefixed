<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Php71;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function processBooleanOr(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\BooleanOr $booleanOr, string $type, string $newMethodName) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($booleanOr, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Instanceof_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class);
        if ($twoNodeMatch === null) {
            return null;
        }
        /** @var Instanceof_ $instanceOfNode */
        $instanceOfNode = $twoNodeMatch->getFirstExpr();
        /** @var FuncCall $funcCallNode */
        $funcCallNode = $twoNodeMatch->getSecondExpr();
        $instanceOfClass = $instanceOfNode->class;
        if ($instanceOfClass instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
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
        if (!$funcCallNode->args[0]->value instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var Variable $firstVarNode */
        $firstVarNode = $funcCallNode->args[0]->value;
        if (!$instanceOfNode->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var Variable $secondVarNode */
        $secondVarNode = $instanceOfNode->expr;
        // are they same variables
        if ($firstVarNode->name !== $secondVarNode->name) {
            return null;
        }
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($newMethodName), [new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($firstVarNode)]);
    }
}
