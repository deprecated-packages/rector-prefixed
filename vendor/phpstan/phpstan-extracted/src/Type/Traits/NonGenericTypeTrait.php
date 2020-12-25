<?php

declare (strict_types=1);
namespace PHPStan\Type\Traits;

use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\Type;
trait NonGenericTypeTrait
{
    public function inferTemplateTypes(\PHPStan\Type\Type $receivedType) : \PHPStan\Type\Generic\TemplateTypeMap
    {
        return \PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [];
    }
}
