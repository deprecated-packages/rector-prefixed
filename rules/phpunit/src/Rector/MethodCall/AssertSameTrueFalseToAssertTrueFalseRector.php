<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use Rector\Core\Rector\AbstractPHPUnitRector;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector\AssertSameTrueFalseToAssertTrueFalseRectorTest
 */
final class AssertSameTrueFalseToAssertTrueFalseRector extends \Rector\Core\Rector\AbstractPHPUnitRector
{
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $this->assertSame(true, ...) to assertTrue()', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

final class SomeTest extends TestCase
{
    public function test()
    {
        $value = (bool) mt_rand(0, 1);
        $this->assertSame(true, $value);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

final class SomeTest extends TestCase
{
    public function test()
    {
        $value = (bool) mt_rand(0, 1);
        $this->assertTrue($value);
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
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, ['assertSame', 'assertEqual', 'assertNotSame', 'assertNotEqual'])) {
            return null;
        }
        if ($this->isTrue($node->args[0]->value)) {
            $this->removeFirstArgument($node);
            $node->name = new \PhpParser\Node\Identifier('assertTrue');
            return $node;
        }
        if ($this->isFalse($node->args[0]->value)) {
            $this->removeFirstArgument($node);
            $node->name = new \PhpParser\Node\Identifier('assertFalse');
            return $node;
        }
        return null;
    }
    private function removeFirstArgument(\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        $args = $methodCall->args;
        \array_shift($args);
        $methodCall->args = $args;
    }
}
