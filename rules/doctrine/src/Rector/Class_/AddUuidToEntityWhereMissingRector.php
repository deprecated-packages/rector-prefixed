<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Doctrine\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Collector\UuidMigrationDataCollector;
use _PhpScoper0a6b37af0871\Rector\Doctrine\NodeFactory\EntityUuidNodeFactory;
use _PhpScoper0a6b37af0871\Rector\Doctrine\Provider\EntityWithMissingUuidProvider;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Doctrine\Tests\Rector\Class_\AddUuidToEntityWhereMissingRector\AddUuidToEntityWhereMissingRectorTest
 *
 * default value is initialized in @see AlwaysInitializeUuidInEntityRector
 */
final class AddUuidToEntityWhereMissingRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Doctrine\NodeFactory\EntityUuidNodeFactory $entityUuidNodeFactory, \_PhpScoper0a6b37af0871\Rector\Doctrine\Provider\EntityWithMissingUuidProvider $entityWithMissingUuidProvider, \_PhpScoper0a6b37af0871\Rector\Doctrine\Collector\UuidMigrationDataCollector $uuidMigrationDataCollector)
    {
        $this->entityUuidNodeFactory = $entityUuidNodeFactory;
        $this->uuidMigrationDataCollector = $uuidMigrationDataCollector;
        $this->entityWithMissingUuidProvider = $entityWithMissingUuidProvider;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds $uuid property to entities, that already have $id with integer type.' . 'Require for step-by-step migration from int to uuid. ' . 'In following step it should be renamed to $id and replace it', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
