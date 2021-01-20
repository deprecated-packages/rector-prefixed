<?php

declare (strict_types=1);
namespace Rector\Doctrine\Uuid;

use RectorPrefix20210120\Nette\Utils\Strings;
use PhpParser\Node\Stmt\Property;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class JoinTableNameResolver
{
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    public function __construct(\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver)
    {
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    /**
     * Create many-to-many table name like: "first_table_second_table_uuid"
     */
    public function resolveManyToManyUuidTableNameForProperty(\PhpParser\Node\Stmt\Property $property) : string
    {
        /** @var string $className */
        $className = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $currentTableName = $this->resolveShortClassName($className);
        $targetEntity = $this->doctrineDocBlockResolver->getTargetEntity($property);
        if ($targetEntity === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $targetTableName = $this->resolveShortClassName($targetEntity);
        return \strtolower($currentTableName . '_' . $targetTableName) . '_uuid';
    }
    private function resolveShortClassName(string $currentClass) : string
    {
        if (!\RectorPrefix20210120\Nette\Utils\Strings::contains($currentClass, '\\')) {
            return $currentClass;
        }
        return (string) \RectorPrefix20210120\Nette\Utils\Strings::after($currentClass, '\\', -1);
    }
}
