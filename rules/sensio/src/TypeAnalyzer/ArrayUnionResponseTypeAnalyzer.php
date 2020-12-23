<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Sensio\TypeAnalyzer;

use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
final class ArrayUnionResponseTypeAnalyzer
{
    public function isArrayUnionResponseType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, string $className) : bool
    {
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            return \false;
        }
        $hasArrayType = \false;
        $hasResponseType = \false;
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
                $hasArrayType = \true;
                continue;
            }
            if ($this->isTypeOfClassName($unionedType, $className)) {
                $hasResponseType = \true;
                continue;
            }
            return \false;
        }
        if (!$hasArrayType) {
            return \false;
        }
        return $hasResponseType;
    }
    private function isTypeOfClassName(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, string $className) : bool
    {
        if (!$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($type->getClassName(), $className, \true);
    }
}
