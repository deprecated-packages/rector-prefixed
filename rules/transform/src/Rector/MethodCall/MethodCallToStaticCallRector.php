<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Rector\MethodCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\MethodCallToStaticCall;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\MethodCall\MethodCallToStaticCallRector\MethodCallToStaticCallRectorTest
 */
final class MethodCallToStaticCallRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_CALLS_TO_STATIC_CALLS = 'method_calls_to_static_calls';
    /**
     * @var MethodCallToStaticCall[]
     */
    private $methodCallsToStaticCalls = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change method call to desired static call', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    private $anotherDependency;

    public function __construct(AnotherDependency $anotherDependency)
    {
        $this->anotherDependency = $anotherDependency;
    }

    public function loadConfiguration()
    {
        return $this->anotherDependency->process('value');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    private $anotherDependency;

    public function __construct(AnotherDependency $anotherDependency)
    {
        $this->anotherDependency = $anotherDependency;
    }

    public function loadConfiguration()
    {
        return StaticCaller::anotherMethod('value');
    }
}
CODE_SAMPLE
, [self::METHOD_CALLS_TO_STATIC_CALLS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\MethodCallToStaticCall('AnotherDependency', 'process', 'StaticCaller', 'anotherMethod')]])]);
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
        foreach ($this->methodCallsToStaticCalls as $methodCallToStaticCall) {
            if (!$this->isObjectType($node->var, $methodCallToStaticCall->getOldClass())) {
                continue;
            }
            if (!$this->isName($node->name, $methodCallToStaticCall->getOldMethod())) {
                continue;
            }
            return $this->createStaticCall($methodCallToStaticCall->getNewClass(), $methodCallToStaticCall->getNewMethod(), $node->args);
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $methodCallsToStaticCalls = $configuration[self::METHOD_CALLS_TO_STATIC_CALLS] ?? [];
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsInstanceOf($methodCallsToStaticCalls, \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\MethodCallToStaticCall::class);
        $this->methodCallsToStaticCalls = $methodCallsToStaticCalls;
    }
}
