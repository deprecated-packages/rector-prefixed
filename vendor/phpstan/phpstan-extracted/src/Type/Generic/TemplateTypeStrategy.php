<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
interface TemplateTypeStrategy
{
    public function accepts(\PHPStan\Type\Generic\TemplateType $left, \PHPStan\Type\Type $right, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function isArgument() : bool;
}
