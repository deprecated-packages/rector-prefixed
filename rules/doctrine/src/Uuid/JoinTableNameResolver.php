<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\Uuid;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
final class JoinTableNameResolver
{
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver)
    {
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    /**
     * Create many-to-many table name like: "first_table_second_table_uuid"
     */
    public function resolveManyToManyUuidTableNameForProperty(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property $property) : string
    {
        /** @var string $className */
        $className = $property->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $currentTableName = $this->resolveShortClassName($className);
        $targetEntity = $this->doctrineDocBlockResolver->getTargetEntity($property);
        if ($targetEntity === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $targetTableName = $this->resolveShortClassName($targetEntity);
        return \strtolower($currentTableName . '_' . $targetTableName) . '_uuid';
    }
    private function resolveShortClassName(string $currentClass) : string
    {
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($currentClass, '\\')) {
            return $currentClass;
        }
        return (string) \_PhpScopere8e811afab72\Nette\Utils\Strings::after($currentClass, '\\', -1);
    }
}
