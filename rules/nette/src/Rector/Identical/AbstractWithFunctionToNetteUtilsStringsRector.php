<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Rector\Identical;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\Nette\Contract\WithFunctionToNetteUtilsStringsRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
abstract class AbstractWithFunctionToNetteUtilsStringsRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Nette\Contract\WithFunctionToNetteUtilsStringsRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $contentExprAndNeedleExpr = $this->resolveContentExprAndNeedleExpr($node);
        if ($contentExprAndNeedleExpr === null) {
            return null;
        }
        $staticCall = $this->createStaticCall('_PhpScoperb75b35f52b74\\Nette\\Utils\\Strings', $this->getMethodName(), [$contentExprAndNeedleExpr->getContentExpr(), $contentExprAndNeedleExpr->getNeedleExpr()]);
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($staticCall);
        }
        return $staticCall;
    }
    /**
     * @param Identical|NotIdentical $node
     */
    private function resolveContentExprAndNeedleExpr($node) : ?\_PhpScoperb75b35f52b74\Rector\Nette\ValueObject\ContentExprAndNeedleExpr
    {
        if ($node->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return $this->matchContentAndNeedleOfSubstrOfVariableLength($node->right, $node->left);
        }
        if ($node->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return $this->matchContentAndNeedleOfSubstrOfVariableLength($node->left, $node->right);
        }
        return null;
    }
}
