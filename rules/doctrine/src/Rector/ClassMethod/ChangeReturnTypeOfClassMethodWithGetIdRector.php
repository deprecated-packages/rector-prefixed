<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DeadCode\Doctrine\DoctrineEntityManipulator;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector\ChangeReturnTypeOfClassMethodWithGetIdRectorTest
 */
final class ChangeReturnTypeOfClassMethodWithGetIdRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineEntityManipulator
     */
    private $doctrineEntityManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\DeadCode\Doctrine\DoctrineEntityManipulator $doctrineEntityManipulator)
    {
        $this->doctrineEntityManipulator = $doctrineEntityManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change getUuid() method call to getId()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function getBuildingId(): int
    {
        $building = new Building();

        return $building->getId();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function getBuildingId(): \Ramsey\Uuid\UuidInterface
    {
        $building = new Building();

        return $building->getId();
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->returnType === null) {
            return null;
        }
        $hasEntityGetIdMethodCall = $this->hasEntityGetIdMethodCall($node);
        if (!$hasEntityGetIdMethodCall) {
            return null;
        }
        $node->returnType = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(\_PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface::class);
        return $node;
    }
    private function hasEntityGetIdMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
                return \false;
            }
            if ($node->expr === null) {
                return \false;
            }
            return $this->doctrineEntityManipulator->isMethodCallOnDoctrineEntity($node->expr, 'getId');
        });
    }
}
