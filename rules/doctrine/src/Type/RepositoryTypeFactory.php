<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\Type;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class RepositoryTypeFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function createRepositoryPropertyType(\_PhpScopere8e811afab72\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType
    {
        if (!$entityReferenceExpr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException();
        }
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($entityReferenceExpr->class);
        return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericObjectType('_PhpScopere8e811afab72\\Doctrine\\ORM\\EntityRepository', [new \_PhpScopere8e811afab72\Rector\PHPStan\Type\FullyQualifiedObjectType($className)]);
    }
}
