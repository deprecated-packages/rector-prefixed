<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isCastableArrayType(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        $callerObjectType = $this->nodeTypeResolver->resolve($expr->var);
        $propertyName = $this->nodeNameResolver->getName($expr->name);
        if (!\is_string($propertyName)) {
            return \false;
        }
        if ($callerObjectType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $callerObjectType = $callerObjectType->getTypes()[0];
        }
        if (!$callerObjectType instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
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
