<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DowngradePhp74\Rector\Identical;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp74\Tests\Rector\Identical\DowngradeFreadFwriteFalsyToNegationRector\DowngradeFreadFwriteFalsyToNegationRectorTest
 */
final class DowngradeFreadFwriteFalsyToNegationRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const FUNC_FREAD_FWRITE = ['fread', 'fwrite'];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes fread() or fwrite() compare to false to negation check', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
fread($handle, $length) === false;
fwrite($fp, '1') === false;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
!fread($handle, $length);
!fwrite($fp, '1');
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param Identical $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $compareValue = $this->getCompareValue($node);
        if ($compareValue === null) {
            return null;
        }
        if (!$this->isFalse($compareValue)) {
            return null;
        }
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($this->getFunction($node));
    }
    private function getCompareValue(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr
    {
        if ($identical->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall && $this->isNames($identical->left, self::FUNC_FREAD_FWRITE)) {
            return $identical->right;
        }
        if ($identical->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall && $this->isNames($identical->right, self::FUNC_FREAD_FWRITE)) {
            return $identical->left;
        }
        return null;
    }
    private function getFunction(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical $identical) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        /** @var FuncCall $funcCall */
        $funcCall = $identical->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall ? $identical->left : $identical->right;
        return $funcCall;
    }
}
