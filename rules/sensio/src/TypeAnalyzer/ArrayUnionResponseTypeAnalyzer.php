<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Sensio\TypeAnalyzer;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
final class ArrayUnionResponseTypeAnalyzer
{
    public function isArrayUnionResponseType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, string $className) : bool
    {
        if (!$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType) {
            return \false;
        }
        $hasArrayType = \false;
        $hasResponseType = \false;
        foreach ($type->getTypes() as $unionedType) {
            if ($unionedType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType) {
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
    private function isTypeOfClassName(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, string $className) : bool
    {
        if (!$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($type->getClassName(), $className, \true);
    }
}
