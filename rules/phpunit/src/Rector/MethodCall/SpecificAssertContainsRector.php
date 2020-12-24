<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/blob/master/ChangeLog-8.0.md
 *
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\SpecificAssertContainsRector\SpecificAssertContainsRectorTest
 */
final class SpecificAssertContainsRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var array<string, string>
     */
    private const OLD_TO_NEW_METHOD_NAMES = ['assertContains' => 'assertStringContainsString', 'assertNotContains' => 'assertStringNotContainsString'];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change assertContains()/assertNotContains() method to new string and iterable alternatives', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, ['assertContains', 'assertNotContains'])) {
            return null;
        }
        if (!$this->isPossiblyStringType($node->args[1]->value)) {
            return null;
        }
        $methodName = $this->getName($node->name);
        $newMethodName = self::OLD_TO_NEW_METHOD_NAMES[$methodName];
        $node->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($newMethodName);
        return $node;
    }
    private function isPossiblyStringType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr) : bool
    {
        $exprType = $this->getStaticType($expr);
        if ($exprType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            foreach ($exprType->getTypes() as $unionedType) {
                if ($unionedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType) {
                    return \true;
                }
            }
        }
        return $exprType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
    }
}
