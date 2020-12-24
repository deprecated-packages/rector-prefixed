<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Rector\StaticCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/blob/5.7.0/src/Framework/TestCase.php#L1623
 * @see https://github.com/sebastianbergmann/phpunit/blob/6.0.0/src/Framework/TestCase.php#L1452
 *
 * @see \Rector\PHPUnit\Tests\Rector\StaticCall\GetMockRector\GetMockRectorTest
 */
final class GetMockRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns getMock*() methods to createMock()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->getMock("Class");', '$this->createMock("Class");'), new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->getMockWithoutInvokingTheOriginalConstructor("Class");', '$this->createMock("Class");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, ['getMock', 'getMockWithoutInvokingTheOriginalConstructor'])) {
            return null;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall && $node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        // narrow args to one
        if (\count((array) $node->args) > 1) {
            $node->args = [$node->args[0]];
        }
        $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('createMock');
        return $node;
    }
}
