<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Rector\Identical;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Nette\Contract\WithFunctionToNetteUtilsStringsRectorInterface;
use _PhpScopere8e811afab72\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
abstract class AbstractWithFunctionToNetteUtilsStringsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Nette\Contract\WithFunctionToNetteUtilsStringsRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $contentExprAndNeedleExpr = $this->resolveContentExprAndNeedleExpr($node);
        if ($contentExprAndNeedleExpr === null) {
            return null;
        }
        $staticCall = $this->createStaticCall('_PhpScopere8e811afab72\\Nette\\Utils\\Strings', $this->getMethodName(), [$contentExprAndNeedleExpr->getContentExpr(), $contentExprAndNeedleExpr->getNeedleExpr()]);
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($staticCall);
        }
        return $staticCall;
    }
    /**
     * @param Identical|NotIdentical $node
     */
    private function resolveContentExprAndNeedleExpr($node) : ?\_PhpScopere8e811afab72\Rector\Nette\ValueObject\ContentExprAndNeedleExpr
    {
        if ($node->left instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return $this->matchContentAndNeedleOfSubstrOfVariableLength($node->right, $node->left);
        }
        if ($node->right instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return $this->matchContentAndNeedleOfSubstrOfVariableLength($node->left, $node->right);
        }
        return null;
    }
}
