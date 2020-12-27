<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc\PHPUnit;

use RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolver;
use RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtension;
use PHPStan\PhpDocParser\Ast\Type\TypeNode;
use PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use PHPStan\Type\NeverType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeWithClassName;
class MockObjectTypeNodeResolverExtension implements \RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverExtension, \RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolverAwareExtension
{
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    public function setTypeNodeResolver(\RectorPrefix20201227\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver) : void
    {
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function getCacheKey() : string
    {
        return 'phpunit-v1';
    }
    public function resolve(\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \RectorPrefix20201227\PHPStan\Analyser\NameScope $nameScope) : ?\PHPStan\Type\Type
    {
        if (!$typeNode instanceof \PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return null;
        }
        static $mockClassNames = ['PHPUnit_Framework_MockObject_MockObject' => \true, 'RectorPrefix20201227\\PHPUnit\\Framework\\MockObject\\MockObject' => \true];
        $types = $this->typeNodeResolver->resolveMultiple($typeNode->types, $nameScope);
        foreach ($types as $type) {
            if (!$type instanceof \PHPStan\Type\TypeWithClassName) {
                continue;
            }
            if (\array_key_exists($type->getClassName(), $mockClassNames)) {
                $resultType = \PHPStan\Type\TypeCombinator::intersect(...$types);
                if ($resultType instanceof \PHPStan\Type\NeverType) {
                    continue;
                }
                return $resultType;
            }
        }
        return null;
    }
}
