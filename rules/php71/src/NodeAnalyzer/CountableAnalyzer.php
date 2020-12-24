<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php71\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use ReflectionClass;
final class CountableAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isCastableArrayType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        $callerObjectType = $this->nodeTypeResolver->resolve($expr->var);
        $propertyName = $this->nodeNameResolver->getName($expr->name);
        if (!\is_string($propertyName)) {
            return \false;
        }
        if ($callerObjectType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            $callerObjectType = $callerObjectType->getTypes()[0];
        }
        if (!$callerObjectType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        $reflectionClass = new \ReflectionClass($callerObjectType->getClassName());
        $propertiesDefaults = $reflectionClass->getDefaultProperties();
        if (!\array_key_exists($propertyName, $propertiesDefaults)) {
            return \false;
        }
        $propertyDefaultValue = $propertiesDefaults[$propertyName];
        return $propertyDefaultValue === null;
    }
}
