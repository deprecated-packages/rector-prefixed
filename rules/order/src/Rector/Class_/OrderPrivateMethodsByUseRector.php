<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Order\Rector\Class_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Trait_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector;
use _PhpScoperb75b35f52b74\Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Order\Tests\Rector\Class_\OrderPrivateMethodsByUseRector\OrderPrivateMethodsByUseRectorTest
 */
final class OrderPrivateMethodsByUseRector extends \_PhpScoperb75b35f52b74\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector
{
    /**
     * @var int
     */
    private const MAX_ATTEMPTS = 5;
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Order private methods in order of their use', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Class_|Trait_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
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
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException('Number of attempts to reorder the methods exceeded');
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
    private function getSortedAndOriginalClassMethods(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike) : \_PhpScoperb75b35f52b74\Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods
    {
        return new \_PhpScoperb75b35f52b74\Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods($this->getLocalPrivateMethodCallOrder($classLike), $this->resolvePrivateClassMethods($classLike));
    }
    /**
     * @return array<int, string>
     */
    private function getLocalPrivateMethodCallOrder(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $localPrivateMethodCallInOrder = [];
        $this->traverseNodesWithCallable($classLike->getMethods(), function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use(&$localPrivateMethodCallInOrder, $classLike) {
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
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
    private function resolvePrivateClassMethods(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $privateClassMethods = [];
        foreach ($classLike->stmts as $key => $classStmt) {
            if (!$classStmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
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
