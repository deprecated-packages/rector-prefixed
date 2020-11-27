<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
interface TemplateTypeStrategy
{
    public function accepts(\PHPStan\Type\Generic\TemplateType $left, \PHPStan\Type\Type $right, bool $strictTypes) : \PHPStan\TrinaryLogic;
    public function isArgument() : bool;
}
