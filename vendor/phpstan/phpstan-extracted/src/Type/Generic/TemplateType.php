<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Generic;

use _PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface TemplateType extends \_PhpScoper0a2ac50786fa\PHPStan\Type\CompoundType
{
    public function getName() : string;
    public function getScope() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeScope;
    public function getBound() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function toArgument() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType;
    public function isArgument() : bool;
    public function isValidVariance(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $a, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $b) : bool;
    public function getVariance() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateTypeVariance;
}
