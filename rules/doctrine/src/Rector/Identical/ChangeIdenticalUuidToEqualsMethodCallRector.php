<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Identical;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Ramsey\Uuid\Uuid;
use _PhpScoper0a6b37af0871\Ramsey\Uuid\UuidInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\DeadCode\Doctrine\DoctrineEntityManipulator;
use _PhpScoper0a6b37af0871\Rector\Php71\ValueObject\TwoNodeMatch;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\Identical\ChangeIdenticalUuidToEqualsMethodCallRector\ChangeIdenticalUuidToEqualsMethodCallRectorTest
 */
final class ChangeIdenticalUuidToEqualsMethodCallRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineEntityManipulator
     */
    private $doctrineEntityManipulator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\DeadCode\Doctrine\DoctrineEntityManipulator $doctrineEntityManipulator)
    {
        $this->doctrineEntityManipulator = $doctrineEntityManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change $uuid === 1 to $uuid->equals(\\Ramsey\\Uuid\\Uuid::fromString(1))', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical::class];
    }
    /**
     * @param Identical $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $twoNodeMatch = $this->matchEntityCallAndComparedVariable($node);
        if ($twoNodeMatch === null) {
            return null;
        }
        $entityMethodCall = $twoNodeMatch->getFirstExpr();
        $comparedVariable = $twoNodeMatch->getSecondExpr();
        $staticCall = $this->createStaticCall(\_PhpScoper0a6b37af0871\Ramsey\Uuid\Uuid::class, 'fromString', [$comparedVariable]);
        return $this->createMethodCall($entityMethodCall, 'equals', [$staticCall]);
    }
    private function matchEntityCallAndComparedVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical $identical) : ?\_PhpScoper0a6b37af0871\Rector\Php71\ValueObject\TwoNodeMatch
    {
        if ($this->doctrineEntityManipulator->isMethodCallOnDoctrineEntity($identical->left, 'getId')) {
            if ($this->isAlreadyUuidType($identical->right)) {
                return null;
            }
            return new \_PhpScoper0a6b37af0871\Rector\Php71\ValueObject\TwoNodeMatch($identical->left, $identical->right);
        }
        if ($this->doctrineEntityManipulator->isMethodCallOnDoctrineEntity($identical->right, 'getId')) {
            if ($this->isAlreadyUuidType($identical->left)) {
                return null;
            }
            return new \_PhpScoper0a6b37af0871\Rector\Php71\ValueObject\TwoNodeMatch($identical->right, $identical->left);
        }
        return null;
    }
    private function isAlreadyUuidType(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        $comparedValueObjectType = $this->getStaticType($expr);
        if (!$comparedValueObjectType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType) {
            return \false;
        }
        return $comparedValueObjectType->getClassName() === \_PhpScoper0a6b37af0871\Ramsey\Uuid\UuidInterface::class;
    }
}
