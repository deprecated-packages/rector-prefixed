<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Traits;

use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
trait NonGenericTypeTrait
{
    public function inferTemplateTypes(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $receivedType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [];
    }
}
