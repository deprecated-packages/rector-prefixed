<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use Rector\Core\Rector\AbstractPHPUnitRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/blob/master/ChangeLog-9.0.md
 * @see https://github.com/sebastianbergmann/phpunit/commit/1ba2e3e1bb091acda3139f8a9259fa8161f3242d
 *
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\ExplicitPhpErrorApiRector\ExplicitPhpErrorApiRectorTest
 */
final class ExplicitPhpErrorApiRector extends \Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var array<string, string>
     */
    private const REPLACEMENTS = ['_PhpScoper8b9c402c5f32\\PHPUnit\\Framework\\TestCase\\Notice' => 'expectNotice', '_PhpScoper8b9c402c5f32\\PHPUnit\\Framework\\TestCase\\Deprecated' => 'expectDeprecation', '_PhpScoper8b9c402c5f32\\PHPUnit\\Framework\\TestCase\\Error' => 'expectError', '_PhpScoper8b9c402c5f32\\PHPUnit\\Framework\\TestCase\\Warning' => 'expectWarning'];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use explicit API for expecting PHP errors, warnings, and notices', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $this->expectException(\PHPUnit\Framework\TestCase\Deprecated::class);
        $this->expectException(\PHPUnit\Framework\TestCase\Error::class);
        $this->expectException(\PHPUnit\Framework\TestCase\Notice::class);
        $this->expectException(\PHPUnit\Framework\TestCase\Warning::class);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeTest extends \PHPUnit\Framework\TestCase
{
    public function test()
    {
        $this->expectDeprecation();
        $this->expectError();
        $this->expectNotice();
        $this->expectWarning();
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
        return [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isPHPUnitMethodNames($node, ['expectException'])) {
            return null;
        }
        foreach (self::REPLACEMENTS as $class => $method) {
            $newNode = $this->replaceExceptionWith($node, $class, $method);
            if ($newNode !== null) {
                return $newNode;
            }
        }
        return $node;
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function replaceExceptionWith(\PhpParser\Node $node, string $exceptionClass, string $explicitMethod) : ?\PhpParser\Node
    {
        if (!isset($node->args[0])) {
            return null;
        }
        if (!$this->isClassConstReference($node->args[0]->value, $exceptionClass)) {
            return null;
        }
        return $this->createPHPUnitCallWithName($node, $explicitMethod);
    }
}
