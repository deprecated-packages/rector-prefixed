<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
interface GlobalConstantReflection
{
    public function getName() : string;
    public function getValueType() : \PHPStan\Type\Type;
    public function isDeprecated() : \PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \PHPStan\TrinaryLogic;
    public function getFileName() : ?string;
}
