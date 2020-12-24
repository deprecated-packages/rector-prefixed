<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Order\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector;
use _PhpScopere8e811afab72\Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Order\Tests\Rector\Class_\OrderPrivateMethodsByUseRector\OrderPrivateMethodsByUseRectorTest
 */
final class OrderPrivateMethodsByUseRector extends \_PhpScopere8e811afab72\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector
{
    /**
     * @var int
     */
    private const MAX_ATTEMPTS = 5;
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Order private methods in order of their use', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Class_|Trait_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
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
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException('Number of attempts to reorder the methods exceeded');
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
    private function getSortedAndOriginalClassMethods(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : \_PhpScopere8e811afab72\Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods
    {
        return new \_PhpScopere8e811afab72\Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods($this->getLocalPrivateMethodCallOrder($classLike), $this->resolvePrivateClassMethods($classLike));
    }
    /**
     * @return array<int, string>
     */
    private function getLocalPrivateMethodCallOrder(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $localPrivateMethodCallInOrder = [];
        $this->traverseNodesWithCallable($classLike->getMethods(), function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$localPrivateMethodCallInOrder, $classLike) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
                return null;
            }
            if (!$this->isVariableName($node->var, 'this')) {
                return null;
            }
            $methodName = $this->getName($node->name);
            if ($methodName === null) {
                return null;
            }
            $classMethod = $classLike->getMethod($methodName);
            if ($classMethod === null) {
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
    private function resolvePrivateClassMethods(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $privateClassMethods = [];
        foreach ($classLike->stmts as $key => $classStmt) {
            if (!$classStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
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
