<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface PropertyReflection extends \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberReflection
{
    public function getReadableType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function getWritableType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function canChangeTypeAfterAssignment() : bool;
    public function isReadable() : bool;
    public function isWritable() : bool;
    public function isDeprecated() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
}
