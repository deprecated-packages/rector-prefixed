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
use Rector\DeadCode\NodeAnalyzer\DataProviderMethodNamesResolver;
use Rector\NodeCollector\ValueObject\ArrayCallable;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnVendorLockResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\DeadCode\Rector\ClassMethod\RemoveUnusedPublicMethodRector\RemoveUnusedPublicMethodRectorTest
 */
final class RemoveUnusedPublicMethodRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var DataProviderMethodNamesResolver
     */
    private $dataProviderMethodNamesResolver;
    /**
     * @var MethodCall[]|StaticCall[]|ArrayCallable[]
     */
    private $calls = [];
    /**
     * @var ClassMethodReturnVendorLockResolver
     */
    private $classMethodReturnVendorLockResolver;
    /**
     * @param \Rector\DeadCode\NodeAnalyzer\DataProviderMethodNamesResolver $dataProviderMethodNamesResolver
     * @param \Rector\VendorLocker\NodeVendorLocker\ClassMethodReturnVendorLockResolver $classMethodReturnVendorLockResolver
     */
    public function __construct($dataProviderMethodNamesResolver, $classMethodReturnVendorLockResolver)
    {
        $this->dataProviderMethodNamesResolver = $dataProviderMethodNamesResolver;
        $this->classMethodReturnVendorLockResolver = $classMethodReturnVendorLockResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused public method', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function unusedpublicMethod()
    {
        // ...
    }

    public function execute()
    {
        // ...
    }

    public function run()
    {
        $obj = new self;
        $obj->execute();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function execute()
    {
        // ...
    }

    public function run()
    {
        $obj = new self;
        $obj->execute();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function refactor($node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $calls = $this->nodeRepository->findCallsByClassMethod($node);
        if ($calls !== []) {
            $this->calls = \array_merge($this->calls, $calls);
            return null;
        }
        if ($this->isRecursionCallClassMethod($node)) {
            return null;
        }
        $this->removeNode($node);
        return $node;
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    private function shouldSkip($classMethod) : bool
    {
        $class = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$class instanceof \PhpParser\Node\Stmt\Class_) {
            return \true;
        }
        if ($this->isOpenSourceProjectType()) {
            return \true;
        }
        if (!$classMethod->isPublic()) {
            return \true;
        }
        if ($this->classMethodReturnVendorLockResolver->isVendorLocked($classMethod)) {
            return \true;
        }
        if ($classMethod->isMagic()) {
            return \true;
        }
        if ($this->isNames($classMethod, ['test', 'test*'])) {
            return \true;
        }
        $class = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        $phpunitDataProviderMethodNames = $this->dataProviderMethodNamesResolver->resolveFromClass($class);
        return $this->isNames($classMethod, $phpunitDataProviderMethodNames);
    }
    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $currentClassMethod
     */
    private function isRecursionCallClassMethod($currentClassMethod) : bool
    {
        /** @var MethodCall[] $calls */
        $calls = $this->calls;
        foreach ($calls as $call) {
            $parentClassMethod = $call->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
            if (!$parentClassMethod) {
                continue;
            }
            if ($this->nodeComparator->areNodesEqual($parentClassMethod, $currentClassMethod)) {
                return \true;
            }
        }
        return \false;
    }
}
