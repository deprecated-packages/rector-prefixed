<?php

declare(strict_types=1);

namespace Rector\Nette\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\UnaryMinus;
use PhpParser\Node\Expr\Variable;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
use Rector\NodeNameResolver\NodeNameResolver;

final class StrlenEndsWithResolver
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var NodeComparator
     */
    private $nodeComparator;

    public function __construct(NodeNameResolver $nodeNameResolver, NodeComparator $nodeComparator)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->nodeComparator = $nodeComparator;
    }

    /**
     * @param Identical|NotIdentical $binaryOp
     * @return \Rector\Nette\ValueObject\ContentExprAndNeedleExpr|null
     */
    public function resolveBinaryOpForFunction(BinaryOp $binaryOp)
    {
        if ($binaryOp->left instanceof Variable) {
            return $this->matchContentExprAndNeedleExpr($binaryOp->right, $binaryOp->left);
        }

        if ($binaryOp->right instanceof Variable) {
            return $this->matchContentExprAndNeedleExpr($binaryOp->left, $binaryOp->right);
        }

        return null;
    }

    /**
     * @return \Rector\Nette\ValueObject\ContentExprAndNeedleExpr|null
     */
    public function matchContentExprAndNeedleExpr(Node $node, Variable $variable)
    {
        if (! $node instanceof FuncCall) {
            return null;
        }

        if (! $this->nodeNameResolver->isName($node, 'substr')) {
            return null;
        }

        /** @var FuncCall $node */
        if (! $node->args[1]->value instanceof UnaryMinus) {
            return null;
        }

        /** @var UnaryMinus $unaryMinus */
        $unaryMinus = $node->args[1]->value;

        if (! $unaryMinus->expr instanceof FuncCall) {
            return null;
        }

        if (! $this->nodeNameResolver->isName($unaryMinus->expr, 'strlen')) {
            return null;
        }

        /** @var FuncCall $strlenFuncCall */
        $strlenFuncCall = $unaryMinus->expr;

        if ($this->nodeComparator->areNodesEqual($strlenFuncCall->args[0]->value, $variable)) {
            return new ContentExprAndNeedleExpr($node->args[0]->value, $strlenFuncCall->args[0]->value);
        }

        return null;
    }
}
