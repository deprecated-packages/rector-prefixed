<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\MethodCallManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/issues/3120
 * "If, and only if, the expects() method is called on this stub to set up expectations then that stub becomes a mock."
 *
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\CreateMockToCreateStubRector\CreateMockToCreateStubRectorTest
 */
final class CreateMockToCreateStubRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var MethodCallManipulator
     */
    private $methodCallManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\MethodCallManipulator $methodCallManipulator)
    {
        $this->methodCallManipulator = $methodCallManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces createMock() with createStub() when relevant', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase

class MyTest extends TestCase
{
    public function testItBehavesAsExpected(): void
    {
        $stub = $this->createMock(\Exception::class);
        $stub->method('getMessage')
            ->willReturn('a message');

        $mock = $this->createMock(\Exception::class);
        $mock->expects($this->once())
            ->method('getMessage')
            ->willReturn('a message');

        self::assertSame('a message', $stub->getMessage());
        self::assertSame('a message', $mock->getMessage());
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase

class MyTest extends TestCase
{
    public function testItBehavesAsExpected(): void
    {
        $stub = $this->createStub(\Exception::class);
        $stub->method('getMessage')
            ->willReturn('a message');

        $mock = $this->createMock(\Exception::class);
        $mock->expects($this->once())
            ->method('getMessage')
            ->willReturn('a message');

        self::assertSame('a message', $stub->getMessage());
        self::assertSame('a message', $mock->getMessage());
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        if (!$this->isName($node->name, 'createMock')) {
            return null;
        }
        $parentNode = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return null;
        }
        $mockVariable = $parentNode->var;
        if (!$mockVariable instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return null;
        }
        $methodCallNamesOnVariable = $this->methodCallManipulator->findMethodCallNamesOnVariable($mockVariable);
        if (\in_array('expects', $methodCallNamesOnVariable, \true)) {
            return null;
        }
        $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('createStub');
        return $node;
    }
}
