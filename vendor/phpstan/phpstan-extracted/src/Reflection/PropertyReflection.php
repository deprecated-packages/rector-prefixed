<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface PropertyReflection extends \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection
{
    public function getReadableType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function getWritableType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function canChangeTypeAfterAssignment() : bool;
    public function isReadable() : bool;
    public function isWritable() : bool;
    public function isDeprecated() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
}
