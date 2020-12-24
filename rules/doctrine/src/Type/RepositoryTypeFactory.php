<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Doctrine\Type;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
final class RepositoryTypeFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function createRepositoryPropertyType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $entityReferenceExpr) : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType
    {
        if (!$entityReferenceExpr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedYetException();
        }
        /** @var string $className */
        $className = $this->nodeNameResolver->getName($entityReferenceExpr->class);
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericObjectType('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\EntityRepository', [new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($className)]);
    }
}
