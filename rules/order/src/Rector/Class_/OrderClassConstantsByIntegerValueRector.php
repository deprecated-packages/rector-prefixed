<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Order\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst;
use _PhpScopere8e811afab72\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Order\Tests\Rector\Class_\OrderClassConstantsByIntegerValueRector\OrderClassConstantsByIntegerValueRectorTest
 */
final class OrderClassConstantsByIntegerValueRector extends \_PhpScopere8e811afab72\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Order class constant order by their integer value', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    const MODE_ON = 0;

    const MODE_OFF = 2;

    const MODE_MAYBE = 1;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    const MODE_ON = 0;

    const MODE_MAYBE = 1;

    const MODE_OFF = 2;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $numericClassConstsByKey = $this->resolveClassConstByPosition($node);
        if ($numericClassConstsByKey === []) {
            return null;
        }
        $classConstConstsByValue = $this->resolveClassConstConstByUniqueValue($numericClassConstsByKey);
        $sortedClassConstConstsByValue = $classConstConstsByValue;
        \asort($sortedClassConstConstsByValue);
        $oldToNewKeys = $this->stmtOrder->createOldToNewKeys($sortedClassConstConstsByValue, $classConstConstsByValue);
        if (!$this->hasOrderChanged($oldToNewKeys)) {
            return null;
        }
        $this->stmtOrder->reorderClassStmtsByOldToNewKeys($node, $oldToNewKeys);
        return $node;
    }
    /**
     * @return ClassConst[]
     */
    private function resolveClassConstByPosition(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : array
    {
        $classConstConstsByValue = [];
        foreach ($class->stmts as $key => $classStmt) {
            if (!$classStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst) {
                continue;
            }
            if (\count((array) $classStmt->consts) !== 1) {
                continue;
            }
            $classConstConst = $classStmt->consts[0];
            if (!$classConstConst->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber) {
                continue;
            }
            $classConstConstsByValue[$key] = $classStmt;
        }
        return $classConstConstsByValue;
    }
    /**
     * @param array<int,ClassConst> $numericClassConstsByKey
     * @return array<int,string>
     */
    private function resolveClassConstConstByUniqueValue(array $numericClassConstsByKey) : array
    {
        $classConstConstsByValue = [];
        foreach ($numericClassConstsByKey as $position => $numericClassConst) {
            $constantValue = $this->getValue($numericClassConst->consts[0]->value);
            $classConstConstsByValue[$position] = $constantValue;
        }
        $arrayCountValue = \array_count_values($classConstConstsByValue);
        // work only with unique constants
        foreach ($classConstConstsByValue as $position => $constantValue) {
            if ($arrayCountValue[$constantValue] > 1) {
                unset($classConstConstsByValue[$position]);
                continue;
            }
        }
        return $classConstConstsByValue;
    }
}
