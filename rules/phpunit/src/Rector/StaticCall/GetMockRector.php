<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPUnit\Rector\StaticCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/blob/5.7.0/src/Framework/TestCase.php#L1623
 * @see https://github.com/sebastianbergmann/phpunit/blob/6.0.0/src/Framework/TestCase.php#L1452
 *
 * @see \Rector\PHPUnit\Tests\Rector\StaticCall\GetMockRector\GetMockRectorTest
 */
final class GetMockRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractPHPUnitRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns getMock*() methods to createMock()', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->getMock("Class");', '$this->createMock("Class");'), new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->getMockWithoutInvokingTheOriginalConstructor("Class");', '$this->createMock("Class");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, ['getMock', 'getMockWithoutInvokingTheOriginalConstructor'])) {
            return null;
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall && $node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        // narrow args to one
        if (\count((array) $node->args) > 1) {
            $node->args = [$node->args[0]];
        }
        $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier('createMock');
        return $node;
    }
}
