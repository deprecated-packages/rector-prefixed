<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc\PHPUnit;

use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use _PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtension;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\NeverType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
class MockObjectTypeNodeResolverExtension implements \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverExtension, \_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolverAwareExtension
{
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    public function setTypeNodeResolver(\_PhpScoperb75b35f52b74\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver) : void
    {
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function getCacheKey() : string
    {
        return 'phpunit-v1';
    }
    public function resolve(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScoperb75b35f52b74\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (!$typeNode instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return null;
        }
        static $mockClassNames = ['PHPUnit_Framework_MockObject_MockObject' => \true, '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\MockObject\\MockObject' => \true];
        $types = $this->typeNodeResolver->resolveMultiple($typeNode->types, $nameScope);
        foreach ($types as $type) {
            if (!$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            if (\array_key_exists($type->getClassName(), $mockClassNames)) {
                $resultType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::intersect(...$types);
                if ($resultType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NeverType) {
                    continue;
                }
                return $resultType;
            }
        }
        return null;
    }
}
