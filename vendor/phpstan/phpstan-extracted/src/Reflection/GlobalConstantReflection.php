<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface GlobalConstantReflection
{
    public function getName() : string;
    public function getValueType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function isDeprecated() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
    public function getFileName() : ?string;
}
