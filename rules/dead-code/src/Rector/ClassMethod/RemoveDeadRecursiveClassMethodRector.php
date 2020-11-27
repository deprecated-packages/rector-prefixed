<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\NodeManipulator\ClassMethodAndCallMatcher;
use Rector\NodeCollector\ValueObject\ArrayCallable;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DeadCode\Tests\Rector\ClassMethod\RemoveDeadRecursiveClassMethodRector\RemoveDeadRecursiveClassMethodRectorTest
 */
final class RemoveDeadRecursiveClassMethodRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var ClassMethodAndCallMatcher
     */
    private $classMethodAndCallMatcher;
    /**
     * @var ClassMethodVendorLockResolver
     */
    private $classMethodVendorLockResolver;
    public function __construct(\Rector\DeadCode\NodeManipulator\ClassMethodAndCallMatcher $classMethodAndCallMatcher, \Rector\VendorLocker\NodeVendorLocker\ClassMethodVendorLockResolver $classMethodVendorLockResolver)
    {
        $this->classMethodAndCallMatcher = $classMethodAndCallMatcher;
        $this->classMethodVendorLockResolver = $classMethodVendorLockResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused public method that only calls itself recursively', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
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
    private function containsClassMethodAnyCalls(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return $this->betterNodeFinder->hasInstancesOf($classMethod, [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class]);
    }
    /**
     * @param StaticCall|MethodCall|ArrayCallable $methodCall
     */
    private function shouldSkipCall(\PhpParser\Node\Stmt\ClassMethod $classMethod, object $methodCall) : bool
    {
        if ($this->classMethodVendorLockResolver->isRemovalVendorLocked($classMethod)) {
            return \true;
        }
        if (!$methodCall instanceof \PhpParser\Node\Expr\MethodCall && !$methodCall instanceof \PhpParser\Node\Expr\StaticCall) {
            return \true;
        }
        /** @var string|null $methodCallMethodName */
        $methodCallMethodName = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
        if ($methodCallMethodName === null) {
            return \true;
        }
        if ($methodCall->name instanceof \PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        // is method called not in itself
        if (!$this->isName($methodCall->name, $methodCallMethodName)) {
            return \true;
        }
        // differnt class, probably inheritance
        $methodCallClassName = $methodCall->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $classMethodClassName = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($methodCallClassName !== $classMethodClassName) {
            return \true;
        }
        return !$this->classMethodAndCallMatcher->isMethodLikeCallMatchingClassMethod($methodCall, $classMethod);
    }
}
