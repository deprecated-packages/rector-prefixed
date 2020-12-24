<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Collector;

use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface;
final class UuidMigrationDataCollector
{
    /**
     * @var string[][][]
     */
    private $columnPropertiesByClass = [];
    /**
     * @var string[][][][]
     */
    private $relationPropertiesByClass = [];
    public function addClassAndColumnProperty(string $class, string $propertyName) : void
    {
        $this->columnPropertiesByClass[$class]['properties'][] = $propertyName;
    }
    public function addClassToManyRelationProperty(string $class, string $oldPropertyName, string $uuidPropertyName, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface $doctrineRelationTagValueNode) : void
    {
        $kind = $this->resolveKind($doctrineRelationTagValueNode);
        $this->relationPropertiesByClass[$class][$kind][] = ['property_name' => $oldPropertyName, 'uuid_property_name' => $uuidPropertyName];
    }
    /**
     * @return string[][][]
     */
    public function getColumnPropertiesByClass() : array
    {
        return $this->columnPropertiesByClass;
    }
    /**
     * @return string[][][][]
     */
    public function getRelationPropertiesByClass() : array
    {
        return $this->relationPropertiesByClass;
    }
    private function resolveKind(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineRelationTagValueNodeInterface $doctrineRelationTagValueNode) : string
    {
        return $doctrineRelationTagValueNode instanceof \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine\ToManyTagNodeInterface ? 'to_many_relations' : 'to_one_relations';
    }
}
