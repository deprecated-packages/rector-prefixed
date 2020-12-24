<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/blob/master/ChangeLog-9.0.md
 * @see https://github.com/sebastianbergmann/phpunit/commit/1ba2e3e1bb091acda3139f8a9259fa8161f3242d
 *
 * @see \Rector\PHPUnit\Tests\Rector\MethodCall\ExplicitPhpErrorApiRector\ExplicitPhpErrorApiRectorTest
 */
final class ExplicitPhpErrorApiRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var array<string, string>
     */
    private const REPLACEMENTS = ['_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase\\Notice' => 'expectNotice', '_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase\\Deprecated' => 'expectDeprecation', '_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase\\Error' => 'expectError', '_PhpScoper0a6b37af0871\\PHPUnit\\Framework\\TestCase\\Warning' => 'expectWarning'];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Use explicit API for expecting PHP errors, warnings, and notices', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
    private function replaceExceptionWith(\_PhpScoper0a6b37af0871\PhpParser\Node $node, string $exceptionClass, string $explicitMethod) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
