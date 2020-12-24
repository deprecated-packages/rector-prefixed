<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Generic;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface TemplateTypeStrategy
{
    public function accepts(\_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType $left, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
    public function isArgument() : bool;
}
