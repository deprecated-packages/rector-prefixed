<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface PropertyReflection extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberReflection
{
    public function getReadableType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function getWritableType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function canChangeTypeAfterAssignment() : bool;
    public function isReadable() : bool;
    public function isWritable() : bool;
    public function isDeprecated() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
}
