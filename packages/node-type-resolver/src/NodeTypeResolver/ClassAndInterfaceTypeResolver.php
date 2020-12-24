<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Reflection\ClassReflectionTypesResolver;
final class ClassAndInterfaceTypeResolver implements \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var ClassReflectionTypesResolver
     */
    private $classReflectionTypesResolver;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Reflection\ClassReflectionTypesResolver $classReflectionTypesResolver, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->classReflectionTypesResolver = $classReflectionTypesResolver;
        $this->typeFactory = $typeFactory;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_::class];
    }
    /**
     * @param Class_|Interface_ $node
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var Scope|null $nodeScope */
        $nodeScope = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope === null) {
            // new node probably
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        /** @var ClassReflection|null $classReflection */
        $classReflection = $nodeScope->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $classTypes = $this->classReflectionTypesResolver->resolve($classReflection);
        return $this->typeFactory->createObjectTypeOrUnionType($classTypes);
    }
}
