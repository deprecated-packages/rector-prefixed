<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\Rector\Class_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeAnalyzer\ColumnDatetimePropertyAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeAnalyzer\ConstructorAssignPropertyAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeFactory\ValueAssignFactory;
use _PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeManipulator\ColumnDatetimePropertyManipulator;
use _PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeManipulator\ConstructorManipulator;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://www.luzanky.cz/ for sponsoring this rule
 *
 * @see https://stackoverflow.com/a/7698687/1348344
 *
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\Class_\MoveCurrentDateTimeDefaultInEntityToConstructorRector\MoveCurrentDateTimeDefaultInEntityToConstructorRectorTest
 */
final class MoveCurrentDateTimeDefaultInEntityToConstructorRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ColumnDatetimePropertyAnalyzer
     */
    private $columnDatetimePropertyAnalyzer;
    /**
     * @var ConstructorManipulator
     */
    private $constructorManipulator;
    /**
     * @var ValueAssignFactory
     */
    private $valueAssignFactory;
    /**
     * @var ColumnDatetimePropertyManipulator
     */
    private $columnDatetimePropertyManipulator;
    /**
     * @var ConstructorAssignPropertyAnalyzer
     */
    private $constructorAssignPropertyAnalyzer;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeAnalyzer\ColumnDatetimePropertyAnalyzer $columnDatetimePropertyAnalyzer, \_PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeManipulator\ConstructorManipulator $constructorManipulator, \_PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeFactory\ValueAssignFactory $valueAssignFactory, \_PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeManipulator\ColumnDatetimePropertyManipulator $columnDatetimePropertyManipulator, \_PhpScoper0a2ac50786fa\Rector\DoctrineCodeQuality\NodeAnalyzer\ConstructorAssignPropertyAnalyzer $constructorAssignPropertyAnalyzer)
    {
        $this->columnDatetimePropertyAnalyzer = $columnDatetimePropertyAnalyzer;
        $this->constructorManipulator = $constructorManipulator;
        $this->valueAssignFactory = $valueAssignFactory;
        $this->columnDatetimePropertyManipulator = $columnDatetimePropertyManipulator;
        $this->constructorAssignPropertyAnalyzer = $constructorAssignPropertyAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Move default value for entity property to constructor, the safest place', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User
{
    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=false, options={"default"="now()"})
     */
    private $when = 'now()';
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User
{
    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $when;

    public function __construct()
    {
        $this->when = new \DateTime();
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        foreach ($node->getProperties() as $property) {
            $this->refactorProperty($property, $node);
        }
        return $node;
    }
    private function refactorProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property
    {
        $columnTagValueNode = $this->columnDatetimePropertyAnalyzer->matchDateTimeColumnTagValueNodeInProperty($property);
        if ($columnTagValueNode === null) {
            return null;
        }
        $constructorAssign = $this->constructorAssignPropertyAnalyzer->resolveConstructorAssign($property);
        // 0. already has default
        if ($constructorAssign !== null) {
            return null;
        }
        // 1. remove default options from database level
        $this->columnDatetimePropertyManipulator->removeDefaultOption($columnTagValueNode);
        // 2. remove default value
        $this->refactorClass($class, $property);
        // 3. remove default from property
        $onlyProperty = $property->props[0];
        $onlyProperty->default = null;
        return $property;
    }
    private function refactorClass(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : void
    {
        /** @var string $propertyName */
        $propertyName = $this->getName($property);
        $onlyProperty = $property->props[0];
        /** @var Expr|null $defaultExpr */
        $defaultExpr = $onlyProperty->default;
        if ($defaultExpr === null) {
            return;
        }
        $expression = $this->valueAssignFactory->createDefaultDateTimeWithValueAssign($propertyName, $defaultExpr);
        $this->constructorManipulator->addStmtToConstructor($class, $expression);
    }
}
