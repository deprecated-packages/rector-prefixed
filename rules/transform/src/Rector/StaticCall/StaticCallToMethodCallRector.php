<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Transform\Rector\StaticCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\AbstractToMethodCallRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector\StaticCallToMethodCallRectorTest
 */
final class StaticCallToMethodCallRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Generic\Rector\AbstractToMethodCallRector
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
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change static call to service method via constructor injection', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
, [self::STATIC_CALLS_TO_METHOD_CALLS => [new \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoper2a4e7ab1ecbc\\Nette\\Utils\\FileSystem', 'write', '_PhpScoper2a4e7ab1ecbc\\Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $classMethod = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethod instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod) {
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
                throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
            }
            return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($expr, $methodName, $node->args);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $staticCallsToMethodCalls = $configuration[self::STATIC_CALLS_TO_METHOD_CALLS] ?? [];
        \_PhpScoper2a4e7ab1ecbc\Webmozart\Assert\Assert::allIsInstanceOf($staticCallsToMethodCalls, \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall::class);
        $this->staticCallsToMethodCalls = $staticCallsToMethodCalls;
    }
    private function refactorToInstanceCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall $staticCall, \_PhpScoper2a4e7ab1ecbc\Rector\Transform\ValueObject\StaticCallToMethodCall $staticCallToMethodCall) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall
    {
        $new = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($staticCallToMethodCall->getClassType()));
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($new, $staticCallToMethodCall->getMethodName(), $staticCall->args);
    }
}
