<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/pull/30813/files#r270879504
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\RemoveExpectAnyFromMockRector\RemoveExpectAnyFromMockRectorTest
 */
final class RemoveExpectAnyFromMockRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove `expect($this->any())` from mocks as it has no added value', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

class SomeClass extends TestCase
{
    public function test()
    {
        $translator = $this->getMock('SomeClass');
        $translator->expects($this->any())
            ->method('trans')
            ->willReturn('translated max {{ max }}!');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

class SomeClass extends TestCase
{
    public function test()
    {
        $translator = $this->getMock('SomeClass');
        $translator->method('trans')
            ->willReturn('translated max {{ max }}!');
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isInTestClass($node)) {
            return null;
        }
        if (!$this->isName($node->name, 'expects')) {
            return null;
        }
        if (\count((array) $node->args) !== 1) {
            return null;
        }
        $onlyArgument = $node->args[0]->value;
        if (!$onlyArgument instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        if (!$this->isName($onlyArgument->var, 'this')) {
            return null;
        }
        if (!$this->isName($onlyArgument->name, 'any')) {
            return null;
        }
        return $node->var;
    }
}
