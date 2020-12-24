<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface TemplateTypeStrategy
{
    public function accepts(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType $left, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $right, bool $strictTypes) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function isArgument() : bool;
}
