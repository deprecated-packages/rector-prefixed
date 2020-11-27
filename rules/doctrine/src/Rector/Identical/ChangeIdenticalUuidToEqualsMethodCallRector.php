<?php

declare (strict_types=1);
namespace Rector\Doctrine\Rector\Identical;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PHPStan\Type\ObjectType;
use _PhpScoper006a73f0e455\Ramsey\Uuid\Uuid;
use _PhpScoper006a73f0e455\Ramsey\Uuid\UuidInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\Doctrine\DoctrineEntityManipulator;
use Rector\Php71\ValueObject\TwoNodeMatch;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\Identical\ChangeIdenticalUuidToEqualsMethodCallRector\ChangeIdenticalUuidToEqualsMethodCallRectorTest
 */
final class ChangeIdenticalUuidToEqualsMethodCallRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineEntityManipulator
     */
    private $doctrineEntityManipulator;
    public function __construct(\Rector\DeadCode\Doctrine\DoctrineEntityManipulator $doctrineEntityManipulator)
    {
        $this->doctrineEntityManipulator = $doctrineEntityManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $uuid === 1 to $uuid->equals(\\Ramsey\\Uuid\\Uuid::fromString(1))', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function match($checkedId): int
    {
        $building = new Building();

        return $building->getId() === $checkedId;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function match($checkedId): int
    {
        $building = new Building();

        return $building->getId()->equals(\Ramsey\Uuid\Uuid::fromString($checkedId));
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
        return [\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param Identical $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $twoNodeMatch = $this->matchEntityCallAndComparedVariable($node);
        if ($twoNodeMatch === null) {
            return null;
        }
        $entityMethodCall = $twoNodeMatch->getFirstExpr();
        $comparedVariable = $twoNodeMatch->getSecondExpr();
        $staticCall = $this->createStaticCall(\_PhpScoper006a73f0e455\Ramsey\Uuid\Uuid::class, 'fromString', [$comparedVariable]);
        return $this->createMethodCall($entityMethodCall, 'equals', [$staticCall]);
    }
    private function matchEntityCallAndComparedVariable(\PhpParser\Node $node) : ?\Rector\Php71\ValueObject\TwoNodeMatch
    {
        if ($this->doctrineEntityManipulator->isMethodCallOnDoctrineEntity($node->left, 'getId')) {
            if ($this->isAlreadyUuidType($node->right)) {
                return null;
            }
            return new \Rector\Php71\ValueObject\TwoNodeMatch($node->left, $node->right);
        }
        if ($this->doctrineEntityManipulator->isMethodCallOnDoctrineEntity($node->right, 'getId')) {
            if ($this->isAlreadyUuidType($node->left)) {
                return null;
            }
            return new \Rector\Php71\ValueObject\TwoNodeMatch($node->right, $node->left);
        }
        return null;
    }
    private function isAlreadyUuidType(\PhpParser\Node\Expr $expr) : bool
    {
        $comparedValueObjectType = $this->getStaticType($expr);
        if (!$comparedValueObjectType instanceof \PHPStan\Type\ObjectType) {
            return \false;
        }
        return $comparedValueObjectType->getClassName() === \_PhpScoper006a73f0e455\Ramsey\Uuid\UuidInterface::class;
    }
}
