<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc\PHPUnit;

use _PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver;
use _PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolverAwareExtension;
use _PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolverExtension;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
class MockObjectTypeNodeResolverExtension implements \_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolverExtension, \_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolverAwareExtension
{
    /** @var TypeNodeResolver */
    private $typeNodeResolver;
    public function setTypeNodeResolver(\_PhpScopere8e811afab72\PHPStan\PhpDoc\TypeNodeResolver $typeNodeResolver) : void
    {
        $this->typeNodeResolver = $typeNodeResolver;
    }
    public function getCacheKey() : string
    {
        return 'phpunit-v1';
    }
    public function resolve(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\TypeNode $typeNode, \_PhpScopere8e811afab72\PHPStan\Analyser\NameScope $nameScope) : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$typeNode instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\UnionTypeNode) {
            return null;
        }
        static $mockClassNames = ['PHPUnit_Framework_MockObject_MockObject' => \true, '_PhpScopere8e811afab72\\PHPUnit\\Framework\\MockObject\\MockObject' => \true];
        $types = $this->typeNodeResolver->resolveMultiple($typeNode->types, $nameScope);
        foreach ($types as $type) {
            if (!$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            if (\array_key_exists($type->getClassName(), $mockClassNames)) {
                $resultType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::intersect(...$types);
                if ($resultType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType) {
                    continue;
                }
                return $resultType;
            }
        }
        return null;
    }
}
