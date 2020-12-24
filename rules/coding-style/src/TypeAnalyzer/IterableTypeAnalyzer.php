<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\TypeAnalyzer;

use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
final class IterableTypeAnalyzer
{
    public function detect(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
            return \true;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType) {
            return \true;
        }
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            foreach ($type->getTypes() as $unionedType) {
                if (!$this->detect($unionedType)) {
                    return \false;
                }
            }
            return \true;
        }
        return \false;
    }
}
