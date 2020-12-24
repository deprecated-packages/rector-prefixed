<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Generic;

use _PhpScoper0a6b37af0871\PHPStan\Type\CompoundType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface TemplateType extends \_PhpScoper0a6b37af0871\PHPStan\Type\CompoundType
{
    public function getName() : string;
    public function getScope() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeScope;
    public function getBound() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function toArgument() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType;
    public function isArgument() : bool;
    public function isValidVariance(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $a, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $b) : bool;
    public function getVariance() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeVariance;
}
