<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\PHPStanStaticTypeMapper;

use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
final class DoctrineTypeAnalyzer
{
    public function isDoctrineCollectionWithIterableUnionType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            return \false;
        }
        $arrayType = null;
        $hasDoctrineCollectionType = \false;
        foreach ($type->getTypes() as $unionedType) {
            if ($this->isCollectionObjectType($unionedType)) {
                $hasDoctrineCollectionType = \true;
            }
            if ($unionedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                $arrayType = $unionedType;
            }
        }
        if (!$hasDoctrineCollectionType) {
            return \false;
        }
        return $arrayType !== null;
    }
    private function isCollectionObjectType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return $type->getClassName() === 'Doctrine\\Common\\Collections\\Collection';
    }
}
