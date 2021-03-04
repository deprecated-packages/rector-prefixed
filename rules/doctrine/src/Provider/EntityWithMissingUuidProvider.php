<?php

declare (strict_types=1);
namespace Rector\Doctrine\Provider;

use RectorPrefix20210304\Nette\Utils\Strings;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use Rector\NodeCollector\NodeCollector\NodeRepository;
use Rector\NodeNameResolver\NodeNameResolver;
final class EntityWithMissingUuidProvider
{
    /**
     * @var string
     * @see https://regex101.com/r/3OnLHU/1
     */
    private const UUID_PREFIX_REGEX = '#^uuid(_binary)?$#';
    /**
     * @var Class_[]
     */
    private $entitiesWithMissingUuidProperty = [];
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    public function __construct(\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory, \Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->phpDocInfoFactory = $phpDocInfoFactory;
        $this->nodeRepository = $nodeRepository;
    }
    /**
     * @return Class_[]
     */
    public function provide() : array
    {
        if ($this->entitiesWithMissingUuidProperty !== [] && !\defined('RECTOR_REPOSITORY')) {
            return $this->entitiesWithMissingUuidProperty;
        }
        $entitiesWithMissingUuidProperty = [];
        foreach ($this->nodeRepository->getClasses() as $class) {
            if (!$this->doctrineDocBlockResolver->isDoctrineEntityClassWithIdProperty($class)) {
                continue;
            }
            $uuidClassProperty = $class->getProperty('uuid');
            // already has $uuid property
            if ($uuidClassProperty !== null) {
                continue;
            }
            if ($this->hasClassIdPropertyWithUuidType($class)) {
                continue;
            }
            $entitiesWithMissingUuidProperty[] = $class;
        }
        $this->entitiesWithMissingUuidProperty = $entitiesWithMissingUuidProperty;
        return $this->entitiesWithMissingUuidProperty;
    }
    private function hasClassIdPropertyWithUuidType(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->getProperties() as $property) {
            if (!$this->nodeNameResolver->isName($property, 'id')) {
                continue;
            }
            return $this->isPropertyClassIdWithUuidType($property);
        }
        return \false;
    }
    private function isPropertyClassIdWithUuidType(\PhpParser\Node\Stmt\Property $property) : bool
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        if (!$phpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode::class)) {
            return \false;
        }
        $columnTagValueNode = $phpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class);
        if (!$columnTagValueNode instanceof \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode) {
            return \false;
        }
        if ($columnTagValueNode->getType() === null) {
            return \false;
        }
        return (bool) \RectorPrefix20210304\Nette\Utils\Strings::match($columnTagValueNode->getType(), self::UUID_PREFIX_REGEX);
    }
}
