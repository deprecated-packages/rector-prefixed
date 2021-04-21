<?php

declare(strict_types=1);

namespace Rector\Php71;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use Rector\Core\NodeManipulator\BinaryOpManipulator;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\Php71\ValueObject\TwoNodeMatch;

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

    public function __construct(BinaryOpManipulator $binaryOpManipulator, NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->binaryOpManipulator = $binaryOpManipulator;
    }

    /**
     * @return \PhpParser\Node\Expr\FuncCall|null
     */
    public function processBooleanOr(BooleanOr $booleanOr, string $type, string $newMethodName)
    {
        $twoNodeMatch = $this->binaryOpManipulator->matchFirstAndSecondConditionNode(
            $booleanOr,
            Instanceof_::class,
            FuncCall::class
        );

        if (! $twoNodeMatch instanceof TwoNodeMatch) {
            return null;
        }

        /** @var Instanceof_ $instanceOf */
        $instanceOf = $twoNodeMatch->getFirstExpr();

        /** @var FuncCall $funcCall */
        $funcCall = $twoNodeMatch->getSecondExpr();

        $instanceOfClass = $instanceOf->class;
        if ($instanceOfClass instanceof Expr) {
            return null;
        }

        if ((string) $instanceOfClass !== $type) {
            return null;
        }

        if (! $this->nodeNameResolver->isName($funcCall, 'is_array')) {
            return null;
        }

        // both use same var
        if (! $funcCall->args[0]->value instanceof Variable) {
            return null;
        }

        /** @var Variable $firstVarNode */
        $firstVarNode = $funcCall->args[0]->value;

        if (! $instanceOf->expr instanceof Variable) {
            return null;
        }

        /** @var Variable $secondVarNode */
        $secondVarNode = $instanceOf->expr;

        // are they same variables
        if ($firstVarNode->name !== $secondVarNode->name) {
            return null;
        }

        return new FuncCall(new Name($newMethodName), [new Arg($firstVarNode)]);
    }
}
