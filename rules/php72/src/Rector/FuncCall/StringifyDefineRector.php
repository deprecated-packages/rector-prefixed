<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/YiTeP
 * @see \Rector\Php72\Tests\Rector\FuncCall\StringifyDefineRector\StringifyDefineRectorTest
 */
final class StringifyDefineRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Make first argument of define() string', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(int $a)
    {
         define(CONSTANT_2, 'value');
         define('CONSTANT', 'value');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(int $a)
    {
         define('CONSTANT_2', 'value');
         define('CONSTANT', 'value');
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isName($node, 'define')) {
            return null;
        }
        if ($this->isStringOrUnionStringOnlyType($node->args[0]->value)) {
            return null;
        }
        if ($node->args[0]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch) {
            $nodeName = $this->getName($node->args[0]->value);
            if ($nodeName === null) {
                return null;
            }
            $node->args[0]->value = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($nodeName);
        }
        return $node;
    }
}
