<?php

declare (strict_types=1);
namespace Rector\Doctrine\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use RectorPrefix20210124\Ramsey\Uuid\UuidInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\Doctrine\DoctrineEntityManipulator;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\ClassMethod\ChangeReturnTypeOfClassMethodWithGetIdRector\ChangeReturnTypeOfClassMethodWithGetIdRectorTest
 */
final class ChangeReturnTypeOfClassMethodWithGetIdRector extends \Rector\Core\Rector\AbstractRector
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
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change getUuid() method call to getId()', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node->returnType === null) {
            return null;
        }
        $hasEntityGetIdMethodCall = $this->hasEntityGetIdMethodCall($node);
        if (!$hasEntityGetIdMethodCall) {
            return null;
        }
        $node->returnType = new \PhpParser\Node\Name\FullyQualified(\RectorPrefix20210124\Ramsey\Uuid\UuidInterface::class);
        return $node;
    }
    private function hasEntityGetIdMethodCall(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\PhpParser\Node $node) : bool {
            if (!$node instanceof \PhpParser\Node\Stmt\Return_) {
                return \false;
            }
            if ($node->expr === null) {
                return \false;
            }
            return $this->doctrineEntityManipulator->isMethodCallOnDoctrineEntity($node->expr, 'getId');
        });
    }
}
