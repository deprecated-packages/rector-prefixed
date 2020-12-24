<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Order;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Interface_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Trait_;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\Contract\RankeableInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\ValueObject\ClassConstRankeable;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\ValueObject\ClassMethodRankeable;
use _PhpScoper2a4e7ab1ecbc\Rector\Order\ValueObject\PropertyRankeable;
final class StmtVisibilitySorter
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param Class_|Trait_ $classLike
     * @return string[]
     */
    public function sortProperties(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $propertyRankeables = [];
        foreach ($classLike->stmts as $position => $propertyStmt) {
            if (!$propertyStmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property) {
                continue;
            }
            /** @var string $propertyName */
            $propertyName = $this->nodeNameResolver->getName($propertyStmt);
            $propertyRankeables[] = new \_PhpScoper2a4e7ab1ecbc\Rector\Order\ValueObject\PropertyRankeable($propertyName, $this->getVisibilityLevelOrder($propertyStmt), $propertyStmt, $position);
        }
        return $this->sortByRanksAndGetNames($propertyRankeables);
    }
    /**
     * @return string[]
     */
    public function sortMethods(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $classMethodsRankeables = [];
        foreach ($classLike->stmts as $position => $classStmt) {
            if (!$classStmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod) {
                continue;
            }
            /** @var string $classMethodName */
            $classMethodName = $this->nodeNameResolver->getName($classStmt);
            $classMethodsRankeables[] = new \_PhpScoper2a4e7ab1ecbc\Rector\Order\ValueObject\ClassMethodRankeable($classMethodName, $this->getVisibilityLevelOrder($classStmt), $position, $classStmt);
        }
        return $this->sortByRanksAndGetNames($classMethodsRankeables);
    }
    /**
     * @param Class_|Interface_ $classLike
     * @return string[]
     */
    public function sortConstants(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $classConstsRankeables = [];
        foreach ($classLike->stmts as $position => $constantStmt) {
            if (!$constantStmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst) {
                continue;
            }
            /** @var string $constantName */
            $constantName = $this->nodeNameResolver->getName($constantStmt);
            $classConstsRankeables[] = new \_PhpScoper2a4e7ab1ecbc\Rector\Order\ValueObject\ClassConstRankeable($constantName, $this->getVisibilityLevelOrder($constantStmt), $position);
        }
        return $this->sortByRanksAndGetNames($classConstsRankeables);
    }
    /**
     * @param ClassMethod|Property|ClassConst $stmt
     */
    private function getVisibilityLevelOrder(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt $stmt) : int
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
        \uasort($rankeables, function (\_PhpScoper2a4e7ab1ecbc\Rector\Order\Contract\RankeableInterface $firstRankeable, \_PhpScoper2a4e7ab1ecbc\Rector\Order\Contract\RankeableInterface $secondRankeable) : int {
            return $firstRankeable->getRanks() <=> $secondRankeable->getRanks();
        });
        $names = [];
        foreach ($rankeables as $rankeable) {
            $names[] = $rankeable->getName();
        }
        return $names;
    }
}
