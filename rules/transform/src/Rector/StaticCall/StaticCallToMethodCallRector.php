<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Rector\StaticCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Generic\Rector\AbstractToMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToMethodCall;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector\StaticCallToMethodCallRectorTest
 */
final class StaticCallToMethodCallRector extends \_PhpScoper0a6b37af0871\Rector\Generic\Rector\AbstractToMethodCallRector
{
    /**
     * @api
     * @var string
     */
    public const STATIC_CALLS_TO_METHOD_CALLS = 'static_calls_to_method_calls';
    /**
     * @var StaticCallToMethodCall[]
     */
    private $staticCallsToMethodCalls = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change static call to service method via constructor injection', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
use Nette\Utils\FileSystem;

class SomeClass
{
    public function run()
    {
        return FileSystem::write('file', 'content');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symplify\SmartFileSystem\SmartFileSystem;

class SomeClass
{
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;

    public function __construct(SmartFileSystem $smartFileSystem)
    {
        $this->smartFileSystem = $smartFileSystem;
    }

    public function run()
    {
        return $this->smartFileSystem->dumpFile('file', 'content');
    }
}
CODE_SAMPLE
, [self::STATIC_CALLS_TO_METHOD_CALLS => [new \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper0a6b37af0871\\Nette\\Utils\\FileSystem', 'write', '_PhpScoper0a6b37af0871\\Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $classMethod = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethod instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        foreach ($this->staticCallsToMethodCalls as $staticCallToMethodCall) {
            if (!$staticCallToMethodCall->isStaticCallMatch($node)) {
                continue;
            }
            if ($classMethod->isStatic()) {
                return $this->refactorToInstanceCall($node, $staticCallToMethodCall);
            }
            $expr = $this->matchTypeProvidingExpr($classLike, $classMethod, $staticCallToMethodCall->getClassType());
            if ($staticCallToMethodCall->getMethodName() === '*') {
                $methodName = $this->getName($node->name);
            } else {
                $methodName = $staticCallToMethodCall->getMethodName();
            }
            if (!\is_string($methodName)) {
                throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
            }
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($expr, $methodName, $node->args);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $staticCallsToMethodCalls = $configuration[self::STATIC_CALLS_TO_METHOD_CALLS] ?? [];
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsInstanceOf($staticCallsToMethodCalls, \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToMethodCall::class);
        $this->staticCallsToMethodCalls = $staticCallsToMethodCalls;
    }
    private function refactorToInstanceCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall, \_PhpScoper0a6b37af0871\Rector\Transform\ValueObject\StaticCallToMethodCall $staticCallToMethodCall) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall
    {
        $new = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($staticCallToMethodCall->getClassType()));
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($new, $staticCallToMethodCall->getMethodName(), $staticCall->args);
    }
}
