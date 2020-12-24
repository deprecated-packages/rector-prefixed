<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Interface_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Reflection\ClassReflectionTypesResolver;
final class ClassAndInterfaceTypeResolver implements \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @var ClassReflectionTypesResolver
     */
    private $classReflectionTypesResolver;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Reflection\ClassReflectionTypesResolver $classReflectionTypesResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->classReflectionTypesResolver = $classReflectionTypesResolver;
        $this->typeFactory = $typeFactory;
    }
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Interface_::class];
    }
    /**
     * @param Class_|Interface_ $node
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        /** @var Scope|null $nodeScope */
        $nodeScope = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope === null) {
            // new node probably
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        /** @var ClassReflection|null $classReflection */
        $classReflection = $nodeScope->getClassReflection();
        if ($classReflection === null) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        }
        $classTypes = $this->classReflectionTypesResolver->resolve($classReflection);
        return $this->typeFactory->createObjectTypeOrUnionType($classTypes);
    }
}
