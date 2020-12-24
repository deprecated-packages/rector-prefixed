<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface FunctionReflection
{
    public function getName() : string;
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array;
    public function isDeprecated() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isFinal() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
    public function isInternal() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
    public function getThrowType() : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function hasSideEffects() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
    public function isBuiltin() : bool;
}
