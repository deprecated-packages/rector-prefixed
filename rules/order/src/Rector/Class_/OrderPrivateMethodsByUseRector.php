<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Order\Rector\Class_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Trait_;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector;
use _PhpScoper0a2ac50786fa\Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Order\Tests\Rector\Class_\OrderPrivateMethodsByUseRector\OrderPrivateMethodsByUseRectorTest
 */
final class OrderPrivateMethodsByUseRector extends \_PhpScoper0a2ac50786fa\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector
{
    /**
     * @var int
     */
    private const MAX_ATTEMPTS = 5;
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Order private methods in order of their use', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Class_|Trait_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
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
                throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException('Number of attempts to reorder the methods exceeded');
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
    private function getSortedAndOriginalClassMethods(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike) : \_PhpScoper0a2ac50786fa\Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods
    {
        return new \_PhpScoper0a2ac50786fa\Rector\Order\ValueObject\SortedClassMethodsAndOriginalClassMethods($this->getLocalPrivateMethodCallOrder($classLike), $this->resolvePrivateClassMethods($classLike));
    }
    /**
     * @return array<int, string>
     */
    private function getLocalPrivateMethodCallOrder(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $localPrivateMethodCallInOrder = [];
        $this->traverseNodesWithCallable($classLike->getMethods(), function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use(&$localPrivateMethodCallInOrder, $classLike) {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
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
    private function resolvePrivateClassMethods(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $privateClassMethods = [];
        foreach ($classLike->stmts as $key => $classStmt) {
            if (!$classStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
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
