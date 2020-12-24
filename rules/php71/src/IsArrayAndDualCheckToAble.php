<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php71;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\BinaryOpManipulator $binaryOpManipulator, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->binaryOpManipulator = $binaryOpManipulator;
    }
    public function processBooleanOr(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\BooleanOr $booleanOr, string $type, string $newMethodName) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode($booleanOr, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class);
        if ($twoNodeMatch === null) {
            return null;
        }
        /** @var Instanceof_ $instanceOfNode */
        $instanceOfNode = $twoNodeMatch->getFirstExpr();
        /** @var FuncCall $funcCallNode */
        $funcCallNode = $twoNodeMatch->getSecondExpr();
        $instanceOfClass = $instanceOfNode->class;
        if ($instanceOfClass instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
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
        if (!$funcCallNode->args[0]->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var Variable $firstVarNode */
        $firstVarNode = $funcCallNode->args[0]->value;
        if (!$instanceOfNode->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return null;
        }
        /** @var Variable $secondVarNode */
        $secondVarNode = $instanceOfNode->expr;
        // are they same variables
        if ($firstVarNode->name !== $secondVarNode->name) {
            return null;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($newMethodName), [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($firstVarNode)]);
    }
}
