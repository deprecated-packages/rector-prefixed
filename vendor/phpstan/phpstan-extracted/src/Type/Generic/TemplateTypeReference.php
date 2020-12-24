<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Generic;

class TemplateTypeReference
{
    /** @var TemplateType */
    private $type;
    /** @var TemplateTypeVariance */
    private $positionVariance;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType $type, \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance)
    {
        $this->type = $type;
        $this->positionVariance = $positionVariance;
    }
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType
    {
        return $this->type;
    }
    public function getPositionVariance() : \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateTypeVariance
    {
        return $this->positionVariance;
    }
}
