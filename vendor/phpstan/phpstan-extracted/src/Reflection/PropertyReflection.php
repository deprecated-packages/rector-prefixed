<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
interface PropertyReflection extends \PHPStan\Reflection\ClassMemberReflection
{
    public function getReadableType() : \PHPStan\Type\Type;
    public function getWritableType() : \PHPStan\Type\Type;
    public function canChangeTypeAfterAssignment() : bool;
    public function isReadable() : bool;
    public function isWritable() : bool;
    public function isDeprecated() : \PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \PHPStan\TrinaryLogic;
}
