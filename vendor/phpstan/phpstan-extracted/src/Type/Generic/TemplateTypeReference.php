<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Generic;

class TemplateTypeReference
{
    /** @var TemplateType */
    private $type;
    /** @var TemplateTypeVariance */
    private $positionVariance;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType $type, \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance)
    {
        $this->type = $type;
        $this->positionVariance = $positionVariance;
    }
    public function getType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType
    {
        return $this->type;
    }
    public function getPositionVariance() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance
    {
        return $this->positionVariance;
    }
}
