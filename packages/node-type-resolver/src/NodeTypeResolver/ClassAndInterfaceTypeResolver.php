<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Reflection\ClassReflectionTypesResolver;
final class ClassAndInterfaceTypeResolver implements \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var ClassReflectionTypesResolver
     */
    private $classReflectionTypesResolver;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Reflection\ClassReflectionTypesResolver $classReflectionTypesResolver, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->classReflectionTypesResolver = $classReflectionTypesResolver;
        $this->typeFactory = $typeFactory;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_::class];
    }
    /**
     * @param Class_|Interface_ $node
     */
    public function resolve(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        /** @var Scope|null $nodeScope */
        $nodeScope = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope === null) {
            // new node probably
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        /** @var ClassReflection|null $classReflection */
        $classReflection = $nodeScope->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        }
        $classTypes = $this->classReflectionTypesResolver->resolve($classReflection);
        return $this->typeFactory->createObjectTypeOrUnionType($classTypes);
    }
}
