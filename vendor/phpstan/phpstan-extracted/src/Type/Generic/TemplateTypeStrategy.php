<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Generic;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface TemplateTypeStrategy
{
    public function accepts(\_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType $left, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function isArgument() : bool;
}
