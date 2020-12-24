<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\PHPUnit;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolverExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
class MockObjectTypeNodeResolverExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolverExtension, \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolverAwareExtension
{
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    public function setTypeNodeResolver(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver) : void
    {
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function getCacheKey() : string
    {
        return 'phpunit-v1';
    }
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if (!$typeNode instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return null;
        }
        static $mockClassNames = ['PHPUnit_Framework_MockObject_MockObject' => \true, '_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\MockObject\\MockObject' => \true];
        $types = $this->typeNodeResolver->resolveMultiple($typeNode->types, $nameScope);
        foreach ($types as $type) {
            if (!$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            if (\array_key_exists($type->getClassName(), $mockClassNames)) {
                $resultType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::intersect(...$types);
                if ($resultType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType) {
                    continue;
                }
                return $resultType;
            }
        }
        return null;
    }
}
