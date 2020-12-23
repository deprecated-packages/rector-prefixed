<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\PHPUnit;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolverExtension;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NeverType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
class MockObjectTypeNodeResolverExtension implements \_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolverExtension, \_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolverAwareExtension
{
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    public function setTypeNodeResolver(\_PhpScoper0a2ac50786fa\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver) : void
    {
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function getCacheKey() : string
    {
        return 'phpunit-v1';
    }
    public function resolve(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if (!$typeNode instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return null;
        }
        static $mockClassNames = ['PHPUnit_Framework_MockObject_MockObject' => \true, '_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\MockObject\\MockObject' => \true];
        $types = $this->typeNodeResolver->resolveMultiple($typeNode->types, $nameScope);
        foreach ($types as $type) {
            if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            if (\array_key_exists($type->getClassName(), $mockClassNames)) {
                $resultType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::intersect(...$types);
                if ($resultType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NeverType) {
                    continue;
                }
                return $resultType;
            }
        }
        return null;
    }
}
