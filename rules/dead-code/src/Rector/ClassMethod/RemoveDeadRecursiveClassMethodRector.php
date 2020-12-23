<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DeadCode\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\DeadCode\NodeManipulator\ClassMethodAndCallMatcher;
use _PhpScoper0a2ac50786fa\Rector\NodeCollector\ValueObject\ArrayCallable;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\ClassMethod\RemoveDeadRecursiveClassMethodRector\RemoveDeadRecursiveClassMethodRectorTest
 */
final class RemoveDeadRecursiveClassMethodRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var ClassMethodAndCallMatcher
     */
    private $classMethodAndCallMatcher;
    /**
     * @var ClassMethodVendorLockResolver
     */
    private $classMethodVendorLockResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\DeadCode\NodeManipulator\ClassMethodAndCallMatcher $classMethodAndCallMatcher, \_PhpScoper0a2ac50786fa\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver $classMethodVendorLockResolver)
    {
        $this->classMethodAndCallMatcher = $classMethodAndCallMatcher;
        $this->classMethodVendorLockResolver = $classMethodVendorLockResolver;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused public method that only calls itself recursively', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return $this->run();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        if (!$this->containsClassMethodAnyCalls($node)) {
            return null;
        }
        $methodCalls = $this->nodeRepository->findCallsByClassMethod($node);
        // handles remove dead methods rules
        if ($methodCalls === []) {
            return null;
        }
        foreach ($methodCalls as $methodCall) {
            if ($this->shouldSkipCall($node, $methodCall)) {
                return null;
            }
        }
        $this->removeNode($node);
        return null;
    }
    private function containsClassMethodAnyCalls(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->betterNodeFinder->hasInstancesOf($classMethod, [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall::class]);
    }
    /**
     * @param StaticCall|MethodCall|ArrayCallable $methodCall
     */
    private function shouldSkipCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, object $methodCall) : bool
    {
        if ($this->classMethodVendorLockResolver->isRemovalVendorLocked($classMethod)) {
            return \true;
        }
        if (!$methodCall instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall && !$methodCall instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
            return \true;
        }
        /** @var string|null $methodCallMethodName */
        $methodCallMethodName = $methodCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        if ($methodCallMethodName === null) {
            return \true;
        }
        if ($methodCall->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        // is method called not in itself
        if (!$this->isName($methodCall->name, $methodCallMethodName)) {
            return \true;
        }
        // differnt class, probably inheritance
        $methodCallClassName = $methodCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $classMethodClassName = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($methodCallClassName !== $classMethodClassName) {
            return \true;
        }
        return !$this->classMethodAndCallMatcher->isMethodLikeCallMatchingClassMethod($methodCall, $classMethod);
    }
}
