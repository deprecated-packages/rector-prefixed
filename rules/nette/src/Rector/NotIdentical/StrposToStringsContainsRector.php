<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Rector\NotIdentical;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/CubLi
 * @see https://github.com/nette/utils/blob/bd961f49b211997202bda1d0fbc410905be370d4/src/Utils/Strings.php#L81
 *
 * @see \Rector\Nette\Tests\Rector\NotIdentical\StrposToStringsContainsRector\StrposToStringsContainsRectorTest
 */
final class StrposToStringsContainsRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use Nette\\Utils\\Strings over bare string-functions', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $name = 'Hi, my name is Tom';
        return strpos($name, 'Hi') !== false;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $name = 'Hi, my name is Tom';
        return \Nette\Utils\Strings::contains($name, 'Hi');
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param NotIdentical|Identical $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $funcCall = $this->matchStrposInComparisonToFalse($node);
        if ($funcCall === null) {
            return null;
        }
        if (isset($funcCall->args[2]) && !$this->isValue($funcCall->args[2]->value, 0)) {
            return null;
        }
        $containsStaticCall = $this->createStaticCall('_PhpScoperb75b35f52b74\\Nette\\Utils\\Strings', 'contains');
        $containsStaticCall->args[0] = $funcCall->args[0];
        $containsStaticCall->args[1] = $funcCall->args[1];
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical) {
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BooleanNot($containsStaticCall);
        }
        return $containsStaticCall;
    }
    private function matchStrposInComparisonToFalse(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp $binaryOp) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        if ($this->isFalse($binaryOp->left)) {
            if (!$binaryOp->right instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if ($this->isName($binaryOp->right, 'strpos')) {
                return $binaryOp->right;
            }
        }
        if ($this->isFalse($binaryOp->right)) {
            if (!$binaryOp->left instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            if ($this->isName($binaryOp->left, 'strpos')) {
                return $binaryOp->left;
            }
        }
        return null;
    }
}
