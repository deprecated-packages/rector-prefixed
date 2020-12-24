<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface FunctionReflection
{
    public function getName() : string;
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array;
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isFinal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function getThrowType() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function hasSideEffects() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
    public function isBuiltin() : bool;
}
