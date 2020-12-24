<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Order\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Order\Tests\Rector\Class_\OrderMethodsByVisibilityRector\OrderMethodsByVisibilityRectorTest
 */
final class OrderMethodsByVisibilityRector extends \_PhpScopere8e811afab72\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector
{
    /**
     * @var string[]
     */
    private const PREFERRED_ORDER = [\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT, \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::DESCTRUCT, '__call', '__callStatic', '__get', '__set', '__isset', '__unset', '__sleep', '__wakeup', '__serialize', '__unserialize', '__toString', '__invoke', \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::SET_STATE, '__clone', 'setUpBeforeClass', 'tearDownAfterClass', \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::SET_UP, \_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::TEAR_DOWN];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Orders method by visibility', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    protected function protectedFunctionName();
    private function privateFunctionName();
    public function publicFunctionName();
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function publicFunctionName();
    protected function protectedFunctionName();
    private function privateFunctionName();
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
        $currentMethodsOrder = $this->stmtOrder->getStmtsOfTypeOrder($node, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class);
        $methodsInDesiredOrder = $this->getMethodsInDesiredOrder($node);
        $oldToNewKeys = $this->stmtOrder->createOldToNewKeys($methodsInDesiredOrder, $currentMethodsOrder);
        // nothing to re-order
        if (!$this->hasOrderChanged($oldToNewKeys)) {
            return null;
        }
        return $this->stmtOrder->reorderClassStmtsByOldToNewKeys($node, $oldToNewKeys);
    }
    /**
     * @return string[]
     */
    private function getMethodsInDesiredOrder(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $classMethodNames = $this->stmtVisibilitySorter->sortMethods($classLike);
        return $this->applyPreferredPosition($classMethodNames);
    }
    /**
     * @param string[] $classMethods
     * @return string[]
     */
    private function applyPreferredPosition(array $classMethods) : array
    {
        return \array_unique(\array_merge(self::PREFERRED_ORDER, $classMethods));
    }
}
