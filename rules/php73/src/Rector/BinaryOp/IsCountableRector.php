<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php73\Rector\BinaryOp;

use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\AbstractIsAbleFunCallRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Php73\Tests\Rector\BinaryOp\IsCountableRector\IsCountableRectorTest
 */
final class IsCountableRector extends \_PhpScoperb75b35f52b74\Rector\Generic\Rector\AbstractIsAbleFunCallRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes is_array + Countable check to is_countable', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
is_array($foo) || $foo instanceof Countable;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
is_countable($foo);
CODE_SAMPLE
)]);
    }
    public function getType() : string
    {
        return 'Countable';
    }
    public function getFuncName() : string
    {
        return 'is_countable';
    }
    public function getPhpVersion() : int
    {
        return \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::IS_COUNTABLE;
    }
}
