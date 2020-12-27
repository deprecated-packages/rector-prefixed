<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
interface PropertyReflection extends \RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection
{
    public function getReadableType() : \PHPStan\Type\Type;
    public function getWritableType() : \PHPStan\Type\Type;
    public function canChangeTypeAfterAssignment() : bool;
    public function isReadable() : bool;
    public function isWritable() : bool;
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
}
