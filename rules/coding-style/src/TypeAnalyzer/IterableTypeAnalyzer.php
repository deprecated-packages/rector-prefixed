<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\TypeAnalyzer;

use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
final class IterableTypeAnalyzer
{
    public function detect(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : bool
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return \true;
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType) {
            return \true;
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
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
