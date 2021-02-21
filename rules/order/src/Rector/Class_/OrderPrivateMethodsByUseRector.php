<?php

declare (strict_types=1);
namespace Rector\Order\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Trait_;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector;
use Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Order\Tests\Rector\Class_\OrderPrivateMethodsByUseRector\OrderPrivateMethodsByUseRectorTest
 */
final class OrderPrivateMethodsByUseRector extends \Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector
{
    /**
     * @var int
     */
    private const MAX_ATTEMPTS = 5;
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Order private methods in order of their use', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->call1();
        $this->call2();
    }

    private function call2()
    {
    }

    private function call1()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->call1();
        $this->call2();
    }

    private function call1()
    {
    }

    private function call2()
    {
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
        return [\PhpParser\Node\Stmt\Class_::class, \PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Class_|Trait_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $sortedAndOriginalClassMethods = $this->getSortedAndOriginalClassMethods($node);
        // order is correct, nothing to change
        if ($sortedAndOriginalClassMethods->hasOrderChanged()) {
            return null;
        }
        // different private method count, one of them is dead probably
        if (!$sortedAndOriginalClassMethods->hasIdenticalClassMethodCount()) {
            return null;
        }
        $attempt = 0;
        while (!$sortedAndOriginalClassMethods->hasOrderSame()) {
            ++$attempt;
            if ($attempt >= self::MAX_ATTEMPTS) {
                throw new \Rector\Core\Exception\ShouldNotHappenException('Number of attempts to reorder the methods exceeded');
            }
            $oldToNewKeys = $this->stmtOrder->createOldToNewKeys($sortedAndOriginalClassMethods->getSortedClassMethods(), $sortedAndOriginalClassMethods->getOriginalClassMethods());
            /** @var Class_ $node */
            $node = $this->stmtOrder->reorderClassStmtsByOldToNewKeys($node, $oldToNewKeys);
            $sortedAndOriginalClassMethods = $this->getSortedAndOriginalClassMethods($node);
        }
        return $node;
    }
    /**
     * @param Class_|Trait_ $classLike
     */
    private function getSortedAndOriginalClassMethods(\PhpParser\Node\Stmt\ClassLike $classLike) : \Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods
    {
        return new \Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods($this->getLocalPrivateMethodCallOrder($classLike), $this->resolvePrivateClassMethods($classLike));
    }
    /**
     * @return array<int, string>
     */
    private function getLocalPrivateMethodCallOrder(\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $localPrivateMethodCallInOrder = [];
        $this->traverseNodesWithCallable($classLike->getMethods(), function (\PhpParser\Node $node) use(&$localPrivateMethodCallInOrder, $classLike) {
            if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->nodeNameResolver->isVariableName($node->var, 'this')) {
                return null;
            }
            $methodName = $this->getName($node->name);
            if ($methodName === null) {
                return null;
            }
            $classMethod = $classLike->getMethod($methodName);
            if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
                return null;
            }
            if ($classMethod->isPrivate()) {
                $localPrivateMethodCallInOrder[] = $methodName;
            }
            return null;
        });
        return \array_unique($localPrivateMethodCallInOrder);
    }
    /**
     * @return array<int, string>
     */
    private function resolvePrivateClassMethods(\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $privateClassMethods = [];
        foreach ($classLike->stmts as $key => $classStmt) {
            if (!$classStmt instanceof \PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            if (!$classStmt->isPrivate()) {
                continue;
            }
            /** @var string $classMethodName */
            $classMethodName = $this->getName($classStmt);
            $privateClassMethods[$key] = $classMethodName;
        }
        return $privateClassMethods;
    }
}
