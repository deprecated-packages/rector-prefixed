<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/blob/master/ChangeLog-8.0.md
 *
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\SpecificAssertContainsRector\SpecificAssertContainsRectorTest
 */
final class SpecificAssertContainsRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var array<string, string>
     */
    private const OLD_TO_NEW_METHOD_NAMES = ['assertContains' => 'assertStringContainsString', 'assertNotContains' => 'assertStringNotContainsString'];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change assertContains()/assertNotContains() method to new string and iterable alternatives', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $this->assertContains('foo', 'foo bar');
        $this->assertNotContains('foo', 'foo bar');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $this->assertStringContainsString('foo', 'foo bar');
        $this->assertStringNotContainsString('foo', 'foo bar');
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, ['assertContains', 'assertNotContains'])) {
            return null;
        }
        if (!$this->isPossiblyStringType($node->args[1]->value)) {
            return null;
        }
        $methodName = $this->getName($node->name);
        $newMethodName = self::OLD_TO_NEW_METHOD_NAMES[$methodName];
        $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($newMethodName);
        return $node;
    }
    private function isPossiblyStringType(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        $exprType = $this->getStaticType($expr);
        if ($exprType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            foreach ($exprType->getTypes() as $unionedType) {
                if ($unionedType instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType) {
                    return \true;
                }
            }
        }
        return $exprType instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType;
    }
}
