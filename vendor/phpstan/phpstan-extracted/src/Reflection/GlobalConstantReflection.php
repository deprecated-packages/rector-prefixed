<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
interface GlobalConstantReflection
{
    public function getName() : string;
    public function getValueType() : \PHPStan\Type\Type;
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getFileName() : ?string;
}
