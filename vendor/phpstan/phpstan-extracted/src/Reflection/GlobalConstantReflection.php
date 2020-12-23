<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection;

use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface GlobalConstantReflection
{
    public function getName() : string;
    public function getValueType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function isDeprecated() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isInternal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
    public function getFileName() : ?string;
}
