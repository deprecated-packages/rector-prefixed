<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
trait NonGenericTypeTrait
{
    public function inferTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $receivedType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [];
    }
}
