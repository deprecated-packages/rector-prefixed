<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\Rector\Identical;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Ramsey\Uuid\Uuid;
use _PhpScoperb75b35f52b74\Ramsey\Uuid\UuidInterface;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\DeadCode\Doctrine\DoctrineEntityManipulator;
use _PhpScoperb75b35f52b74\Rector\Php71\ValueObject\TwoNodeMatch;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\Identical\ChangeIdenticalUuidToEqualsMethodCallRector\ChangeIdenticalUuidToEqualsMethodCallRectorTest
 */
final class ChangeIdenticalUuidToEqualsMethodCallRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineEntityManipulator
     */
    private $doctrineEntityManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\DeadCode\Doctrine\DoctrineEntityManipulator $doctrineEntityManipulator)
    {
        $this->doctrineEntityManipulator = $doctrineEntityManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $uuid === 1 to $uuid->equals(\\Ramsey\\Uuid\\Uuid::fromString(1))', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param Identical $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $twoNodeMatch = $this->matchEntityCallAndComparedVariable($node);
        if ($twoNodeMatch === null) {
            return null;
        }
        $entityMethodCall = $twoNodeMatch->getFirstExpr();
        $comparedVariable = $twoNodeMatch->getSecondExpr();
        $staticCall = $this->createStaticCall(\_PhpScoperb75b35f52b74\Ramsey\Uuid\Uuid::class, 'fromString', [$comparedVariable]);
        return $this->createMethodCall($entityMethodCall, 'equals', [$staticCall]);
    }
    private function matchEntityCallAndComparedVariable(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScoperb75b35f52b74\Rector\Php71\ValueObject\TwoNodeMatch
    {
        if ($this->doctrineEntityManipulator->isMethodCallOnDoctrineEntity($identical->left, 'getId')) {
            if ($this->isAlreadyUuidType($identical->right)) {
                return null;
            }
            return new \_PhpScoperb75b35f52b74\Rector\Php71\ValueObject\TwoNodeMatch($identical->left, $identical->right);
        }
        if ($this->doctrineEntityManipulator->isMethodCallOnDoctrineEntity($identical->right, 'getId')) {
            if ($this->isAlreadyUuidType($identical->left)) {
                return null;
            }
            return new \_PhpScoperb75b35f52b74\Rector\Php71\ValueObject\TwoNodeMatch($identical->right, $identical->left);
        }
        return null;
    }
    private function isAlreadyUuidType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        $comparedValueObjectType = $this->getStaticType($expr);
        if (!$comparedValueObjectType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $comparedValueObjectType->getClassName() === \_PhpScoperb75b35f52b74\Ramsey\Uuid\UuidInterface::class;
    }
}
