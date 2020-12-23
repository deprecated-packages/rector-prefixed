<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Order\Rector\Class_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Trait_;
use _PhpScoper0a2ac50786fa\Rector\Order\PropertyRanker;
use _PhpScoper0a2ac50786fa\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector;
use _PhpScoper0a2ac50786fa\Rector\Order\ValueObject\PropertyNameRankAndPosition;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Order\Tests\Rector\Class_\OrderPropertyByComplexityRector\OrderPropertyByComplexityRectorTest
 */
final class OrderPropertyByComplexityRector extends \_PhpScoper0a2ac50786fa\Rector\Order\Rector\AbstractConstantPropertyMethodOrderRector
{
    /**
     * @var PropertyRanker
     */
    private $propertyRanker;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Order\PropertyRanker $propertyRanker)
    {
        $this->propertyRanker = $propertyRanker;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Order properties by complexity, from the simplest like scalars to the most complex, like union or collections', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Type
     */
    private $service;

    /**
     * @var int
     */
    private $price;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass implements FoodRecipeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $price;

    /**
     * @var Type
     */
    private $service;
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
        $propertyByVisibilityByPosition = $this->resolvePropertyByVisibilityByPosition($node);
        $hasChanged = \false;
        foreach ($propertyByVisibilityByPosition as $propertyByPosition) {
            $propertyPositionByName = [];
            $propertyNamesRanksAndPositions = [];
            foreach ($propertyByPosition as $position => $property) {
                /** @var string $propertyName */
                $propertyName = $this->getName($property);
                $propertyPositionByName[$position] = $propertyName;
                $rank = $this->propertyRanker->rank($property);
                $propertyNamesRanksAndPositions[] = new \_PhpScoper0a2ac50786fa\Rector\Order\ValueObject\PropertyNameRankAndPosition($propertyName, $rank, $position);
            }
            $sortedPropertyByRank = $this->getSortedPropertiesByRankAndPosition($propertyNamesRanksAndPositions);
            $oldToNewKeys = $this->stmtOrder->createOldToNewKeys($sortedPropertyByRank, $propertyPositionByName);
            // nothing to re-order
            if (!$this->hasOrderChanged($oldToNewKeys)) {
                continue;
            }
            $hasChanged = \true;
            $this->stmtOrder->reorderClassStmtsByOldToNewKeys($node, $oldToNewKeys);
        }
        if ($hasChanged) {
            return $node;
        }
        return null;
    }
    /**
     * @param Class_|Trait_ $classLike
     * @return array<string, Property[]>
     */
    private function resolvePropertyByVisibilityByPosition(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike $classLike) : array
    {
        $propertyByVisibilityByPosition = [];
        foreach ((array) $classLike->stmts as $position => $classStmt) {
            if (!$classStmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property) {
                continue;
            }
            $visibility = $this->getVisibilityAsString($classStmt);
            $propertyByVisibilityByPosition[$visibility][$position] = $classStmt;
        }
        return $propertyByVisibilityByPosition;
    }
    /**
     * @param PropertyNameRankAndPosition[] $propertyNamesRanksAndPositions
     * @return string[]
     */
    private function getSortedPropertiesByRankAndPosition(array $propertyNamesRanksAndPositions) : array
    {
        \uasort($propertyNamesRanksAndPositions, function (\_PhpScoper0a2ac50786fa\Rector\Order\ValueObject\PropertyNameRankAndPosition $firstArray, \_PhpScoper0a2ac50786fa\Rector\Order\ValueObject\PropertyNameRankAndPosition $secondArray) : int {
            return [$firstArray->getRank(), $firstArray->getPosition()] <=> [$secondArray->getRank(), $secondArray->getPosition()];
        });
        $propertyNames = [];
        foreach ($propertyNamesRanksAndPositions as $propertyNameRankAndPosition) {
            $propertyNames[] = $propertyNameRankAndPosition->getName();
        }
        return $propertyNames;
    }
    private function getVisibilityAsString(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : string
    {
        if ($property->isPrivate()) {
            return 'private';
        }
        if ($property->isProtected()) {
            return 'protected';
        }
        return 'public';
    }
}
