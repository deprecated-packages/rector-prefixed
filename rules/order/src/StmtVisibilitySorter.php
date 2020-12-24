<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Order;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\Order\Contract\RankeableInterface;
use _PhpScopere8e811afab72\Rector\Order\ValueObject\ClassConstRankeable;
use _PhpScopere8e811afab72\Rector\Order\ValueObject\ClassMethodRankeable;
use _PhpScopere8e811afab72\Rector\Order\ValueObject\PropertyRankeable;
final class StmtVisibilitySorter
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Class_|Trait_ $classLike
     * @return string[]
     */
    public function sortProperties(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $propertyRankeables = [];
        foreach ($classLike->stmts as $position => $propertyStmt) {
            if (!$propertyStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property) {
                continue;
            }
            /** @var string $propertyName */
            $propertyName = $this->nodeNameResolver->getName($propertyStmt);
            $propertyRankeables[] = new \_PhpScopere8e811afab72\Rector\Order\ValueObject\PropertyRankeable($propertyName, $this->getVisibilityLevelOrder($propertyStmt), $propertyStmt, $position);
        }
        return $this->sortByRanksAndGetNames($propertyRankeables);
    }
    /**
     * @return string[]
     */
    public function sortMethods(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $classMethodsRankeables = [];
        foreach ($classLike->stmts as $position => $classStmt) {
            if (!$classStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            /** @var string $classMethodName */
            $classMethodName = $this->nodeNameResolver->getName($classStmt);
            $classMethodsRankeables[] = new \_PhpScopere8e811afab72\Rector\Order\ValueObject\ClassMethodRankeable($classMethodName, $this->getVisibilityLevelOrder($classStmt), $position, $classStmt);
        }
        return $this->sortByRanksAndGetNames($classMethodsRankeables);
    }
    /**
     * @param Class_|Interface_ $classLike
     * @return string[]
     */
    public function sortConstants(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $classConstsRankeables = [];
        foreach ($classLike->stmts as $position => $constantStmt) {
            if (!$constantStmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst) {
                continue;
            }
            /** @var string $constantName */
            $constantName = $this->nodeNameResolver->getName($constantStmt);
            $classConstsRankeables[] = new \_PhpScopere8e811afab72\Rector\Order\ValueObject\ClassConstRankeable($constantName, $this->getVisibilityLevelOrder($constantStmt), $position);
        }
        return $this->sortByRanksAndGetNames($classConstsRankeables);
    }
    /**
     * @param ClassMethod|Property|ClassConst $stmt
     */
    private function getVisibilityLevelOrder(\_PhpScopere8e811afab72\PhpParser\Node\Stmt $stmt) : int
    {
        if ($stmt->isPrivate()) {
            return 2;
        }
        if ($stmt->isProtected()) {
            return 1;
        }
        return 0;
    }
    /**
     * @param RankeableInterface[] $rankeables
     * @return string[]
     */
    private function sortByRanksAndGetNames(array $rankeables) : array
    {
        \uasort($rankeables, function (\_PhpScopere8e811afab72\Rector\Order\Contract\RankeableInterface $firstRankeable, \_PhpScopere8e811afab72\Rector\Order\Contract\RankeableInterface $secondRankeable) : int {
            return $firstRankeable->getRanks() <=> $secondRankeable->getRanks();
        });
        $names = [];
        foreach ($rankeables as $rankeable) {
            $names[] = $rankeable->getName();
        }
        return $names;
    }
}
