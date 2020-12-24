<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DeadCode\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DeadCode\NodeManipulator\ClassMethodAndCallMatcher;
use _PhpScopere8e811afab72\Rector\NodeCollector\ValueObject\ArrayCallable;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\ClassMethod\RemoveDeadRecursiveClassMethodRector\RemoveDeadRecursiveClassMethodRectorTest
 */
final class RemoveDeadRecursiveClassMethodRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var ClassMethodAndCallMatcher
     */
    private $classMethodAndCallMatcher;
    /**
     * @var ClassMethodVendorLockResolver
     */
    private $classMethodVendorLockResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\DeadCode\NodeManipulator\ClassMethodAndCallMatcher $classMethodAndCallMatcher, \_PhpScopere8e811afab72\Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver $classMethodVendorLockResolver)
    {
        $this->classMethodAndCallMatcher = $classMethodAndCallMatcher;
        $this->classMethodVendorLockResolver = $classMethodVendorLockResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused public method that only calls itself recursively', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
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
    private function containsClassMethodAnyCalls(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->betterNodeFinder->hasInstancesOf($classMethod, [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class]);
    }
    /**
     * @param StaticCall|MethodCall|ArrayCallable $methodCall
     */
    private function shouldSkipCall(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, object $methodCall) : bool
    {
        if ($this->classMethodVendorLockResolver->isRemovalVendorLocked($classMethod)) {
            return \true;
        }
        if (!$methodCall instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall && !$methodCall instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return \true;
        }
        /** @var string|null $methodCallMethodName */
        $methodCallMethodName = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        if ($methodCallMethodName === null) {
            return \true;
        }
        if ($methodCall->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        // is method called not in itself
        if (!$this->isName($methodCall->name, $methodCallMethodName)) {
            return \true;
        }
        // differnt class, probably inheritance
        $methodCallClassName = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $classMethodClassName = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($methodCallClassName !== $classMethodClassName) {
            return \true;
        }
        return !$this->classMethodAndCallMatcher->isMethodLikeCallMatchingClassMethod($methodCall, $classMethod);
    }
}
