<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Traits;

use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
trait NonGenericTypeTrait
{
    public function inferTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $receivedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getReferencedTemplateTypes(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance) : array
    {
        return [];
    }
}
