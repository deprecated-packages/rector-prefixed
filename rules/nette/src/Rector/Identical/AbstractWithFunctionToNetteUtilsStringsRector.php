<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Nette\Rector\Identical;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Nette\Contract\WithFunctionToNetteUtilsStringsRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Nette\ValueObject\ContentExprAndNeedleExpr;
abstract class AbstractWithFunctionToNetteUtilsStringsRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Nette\Contract\WithFunctionToNetteUtilsStringsRectorInterface
{
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Identical::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical::class];
    }
    /**
     * @param Identical|NotIdentical $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $contentExprAndNeedleExpr = $this->resolveContentExprAndNeedleExpr($node);
        if ($contentExprAndNeedleExpr === null) {
            return null;
        }
        $staticCall = $this->createStaticCall('_PhpScoper0a2ac50786fa\\Nette\\Utils\\Strings', $this->getMethodName(), [$contentExprAndNeedleExpr->getContentExpr(), $contentExprAndNeedleExpr->getNeedleExpr()]);
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BooleanNot($staticCall);
        }
        return $staticCall;
    }
    /**
     * @param Identical|NotIdentical $node
     */
    private function resolveContentExprAndNeedleExpr($node) : ?\_PhpScoper0a2ac50786fa\Rector\Nette\ValueObject\ContentExprAndNeedleExpr
    {
        if ($node->left instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return $this->matchContentAndNeedleOfSubstrOfVariableLength($node->right, $node->left);
        }
        if ($node->right instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return $this->matchContentAndNeedleOfSubstrOfVariableLength($node->left, $node->right);
        }
        return null;
    }
}
