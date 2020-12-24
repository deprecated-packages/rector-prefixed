<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Generic;

class TemplateTypeReference
{
    /** @var TemplateType */
    private $type;
    /** @var TemplateTypeVariance */
    private $positionVariance;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType $type, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance)
    {
        $this->type = $type;
        $this->positionVariance = $positionVariance;
    }
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType
    {
        return $this->type;
    }
    public function getPositionVariance() : \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeVariance
    {
        return $this->positionVariance;
    }
}
