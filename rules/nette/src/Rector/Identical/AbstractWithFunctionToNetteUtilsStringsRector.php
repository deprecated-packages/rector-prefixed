<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Nette\Rector\Identical;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\Contract\WithFunctionToNetteUtilsStringsRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
abstract class AbstractWithFunctionToNetteUtilsStringsRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Nette\Contract\WithFunctionToNetteUtilsStringsRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $contentExprAndNeedleExpr = $this->resolveContentExprAndNeedleExpr($node);
        if ($contentExprAndNeedleExpr === null) {
            return null;
        }
        $staticCall = $this->createStaticCall('_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\Strings', $this->getMethodName(), [$contentExprAndNeedleExpr->getContentExpr(), $contentExprAndNeedleExpr->getNeedleExpr()]);
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\BooleanNot($staticCall);
        }
        return $staticCall;
    }
    /**
     * @param Identical|NotIdentical $node
     */
    private function resolveContentExprAndNeedleExpr($node) : ?\_PhpScoper2a4e7ab1ecbc\Rector\Nette\ValueObject\ContentExprAndNeedleExpr
    {
        if ($node->left instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            return $this->matchContentAndNeedleOfSubstrOfVariableLength($node->right, $node->left);
        }
        if ($node->right instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            return $this->matchContentAndNeedleOfSubstrOfVariableLength($node->left, $node->right);
        }
        return null;
    }
}
