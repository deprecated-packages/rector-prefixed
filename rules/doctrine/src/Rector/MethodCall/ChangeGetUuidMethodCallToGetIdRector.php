<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\DeadCode\Doctrine\DoctrineEntityManipulator;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\MethodCall\ChangeGetUuidMethodCallToGetIdRector\ChangeGetUuidMethodCallToGetIdRectorTest
 */
final class ChangeGetUuidMethodCallToGetIdRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
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
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class SomeClass
{
    public function run()
    {
        $buildingFirst = new Building();

        return $buildingFirst->getUuid()->toString();
    }
}

/**
 * @ORM\Entity
 */
class UuidEntity
{
    private $uuid;
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class SomeClass
{
    public function run()
    {
        $buildingFirst = new Building();

        return $buildingFirst->getId()->toString();
    }
}

/**
 * @ORM\Entity
 */
class UuidEntity
{
    private $uuid;
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->doctrineEntityManipulator->isMethodCallOnDoctrineEntity($node, 'getUuid')) {
            return null;
        }
        $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('getId');
        return $node;
    }
}
