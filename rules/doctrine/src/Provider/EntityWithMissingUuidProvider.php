<?php

declare (strict_types=1);
namespace Rector\Doctrine\Provider;

use _PhpScoper006a73f0e455\Nette\Utils\Strings;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode;
use Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
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
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector)
    {
        $this->parsedNodeCollector = $parsedNodeCollector;
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
        $this->nodeNameResolver = $nodeNameResolver;
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
        foreach ($this->parsedNodeCollector->getClasses() as $class) {
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
        foreach ($class->stmts as $classStmt) {
            if (!$classStmt instanceof \PhpParser\Node\Stmt\Property) {
                continue;
            }
            if (!$this->nodeNameResolver->isName($classStmt, 'id')) {
                continue;
            }
            return $this->isPropertyClassIdWithUuidType($classStmt);
        }
        return \false;
    }
    private function isPropertyClassIdWithUuidType(\PhpParser\Node\Stmt\Property $property) : bool
    {
        /** @var PhpDocInfo $propertyPhpDocInfo */
        $propertyPhpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$propertyPhpDocInfo->hasByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\IdTagValueNode::class)) {
            return \false;
        }
        $columnTagValueNode = $propertyPhpDocInfo->getByType(\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode::class);
        if ($columnTagValueNode === null) {
            return \false;
        }
        if ($columnTagValueNode->getType() === null) {
            return \false;
        }
        return (bool) \_PhpScoper006a73f0e455\Nette\Utils\Strings::match($columnTagValueNode->getType(), self::UUID_PREFIX_REGEX);
    }
}
