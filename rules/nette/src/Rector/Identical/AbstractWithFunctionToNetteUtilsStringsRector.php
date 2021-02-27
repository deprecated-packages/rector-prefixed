<?php

declare (strict_types=1);
namespace Rector\Nette\Rector\Identical;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\Variable;
use Rector\Core\Rector\AbstractRector;
use Rector\Nette\Contract\WithFunctionToNetteUtilsStringsRectorInterface;
use Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
abstract class AbstractWithFunctionToNetteUtilsStringsRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Nette\Contract\WithFunctionToNetteUtilsStringsRectorInterface
{
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\BinaryOp\Identical::class, \PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $contentExprAndNeedleExpr = $this->resolveContentExprAndNeedleExpr($node);
        if (!$contentExprAndNeedleExpr instanceof \Rector\Nette\ValueObject\ContentExprAndNeedleExpr) {
            return null;
        }
        $staticCall = $this->nodeFactory->createStaticCall('Nette\\Utils\\Strings', $this->getMethodName(), [$contentExprAndNeedleExpr->getContentExpr(), $contentExprAndNeedleExpr->getNeedleExpr()]);
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return new \PhpParser\Node\Expr\BooleanNot($staticCall);
        }
        return $staticCall;
    }
    /**
     * @param Identical|NotIdentical $binaryOp
     */
    private function resolveContentExprAndNeedleExpr(\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\Rector\Nette\ValueObject\ContentExprAndNeedleExpr
    {
        if ($binaryOp->left instanceof \PhpParser\Node\Expr\Variable) {
            return $this->matchContentAndNeedleOfSubstrOfVariableLength($binaryOp->right, $binaryOp->left);
        }
        if ($binaryOp->right instanceof \PhpParser\Node\Expr\Variable) {
            return $this->matchContentAndNeedleOfSubstrOfVariableLength($binaryOp->left, $binaryOp->right);
        }
        return null;
    }
}
