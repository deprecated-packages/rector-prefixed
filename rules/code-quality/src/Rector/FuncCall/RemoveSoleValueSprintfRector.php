<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodeQuality\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\FuncCall\RemoveSoleValueSprintfRector\RemoveSoleValueSprintfRectorTest
 */
final class RemoveSoleValueSprintfRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove sprintf() wrapper if not needed', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = sprintf('%s', 'hi');

        $welcome = 'hello';
        $value = sprintf('%s', $welcome);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = 'hi';

        $welcome = 'hello';
        $value = $welcome;
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isName($node, 'sprintf')) {
            return null;
        }
        if (\count((array) $node->args) !== 2) {
            return null;
        }
        $maskArgument = $node->args[0]->value;
        if (!$maskArgument instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            return null;
        }
        if ($maskArgument->value !== '%s') {
            return null;
        }
        $valueArgument = $node->args[1]->value;
        if (!$this->isStaticType($valueArgument, \_PhpScoperb75b35f52b74\PHPStan\Type\StringType::class)) {
            return null;
        }
        return $valueArgument;
    }
}
