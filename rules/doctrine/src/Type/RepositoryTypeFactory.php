<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Doctrine\Type;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class RepositoryTypeFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function createRepositoryPropertyType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType
    {
        if (!$entityReferenceExpr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\NotImplementedYetException();
        }
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($entityReferenceExpr->class);
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericObjectType('_PhpScoper0a2ac50786fa\\Doctrine\\ORM\\EntityRepository', [new \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\FullyQualifiedObjectType($className)]);
    }
}
