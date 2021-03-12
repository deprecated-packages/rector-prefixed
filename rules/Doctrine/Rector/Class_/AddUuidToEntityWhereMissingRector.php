<?php

declare (strict_types=1);
namespace Rector\Doctrine\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Core\Rector\AbstractRector;
use Rector\Doctrine\Collector\UuidMigrationDataCollector;
use Rector\Doctrine\NodeFactory\EntityUuidNodeFactory;
use Rector\Doctrine\Provider\EntityWithMissingUuidProvider;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Tests\Doctrine\Rector\Class_\AddUuidToEntityWhereMissingRector\AddUuidToEntityWhereMissingRectorTest
 *
 * default value is initialized in @see AlwaysInitializeUuidInEntityRector
 */
final class AddUuidToEntityWhereMissingRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var EntityUuidNodeFactory
     */
    private $entityUuidNodeFactory;
    /**
     * @var UuidMigrationDataCollector
     */
    private $uuidMigrationDataCollector;
    /**
     * @var EntityWithMissingUuidProvider
     */
    private $entityWithMissingUuidProvider;
    public function __construct(\Rector\Doctrine\NodeFactory\EntityUuidNodeFactory $entityUuidNodeFactory, \Rector\Doctrine\Provider\EntityWithMissingUuidProvider $entityWithMissingUuidProvider, \Rector\Doctrine\Collector\UuidMigrationDataCollector $uuidMigrationDataCollector)
    {
        $this->entityUuidNodeFactory = $entityUuidNodeFactory;
        $this->uuidMigrationDataCollector = $uuidMigrationDataCollector;
        $this->entityWithMissingUuidProvider = $entityWithMissingUuidProvider;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds $uuid property to entities, that already have $id with integer type.' . 'Require for step-by-step migration from int to uuid. ' . 'In following step it should be renamed to $id and replace it', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeEntityWithIntegerId
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SomeEntityWithIntegerId
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * @ORM\Column(type="uuid_binary", unique=true, nullable=true)
     */
    private $uuid;
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $entitiesWithMissingUuidProperty = $this->entityWithMissingUuidProvider->provide();
        if (!\in_array($node, $entitiesWithMissingUuidProperty, \true)) {
            return null;
        }
        // add to start of the class, so it can be easily seen
        $uuidProperty = $this->entityUuidNodeFactory->createTemporaryUuidProperty();
        $node->stmts = \array_merge([$uuidProperty], $node->stmts);
        /** @var string $class */
        $class = $this->getName($node);
        $this->uuidMigrationDataCollector->addClassAndColumnProperty($class, 'uuid');
        return $node;
    }
}
