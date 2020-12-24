<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
interface MethodReflection extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberReflection
{
    public function getName() : string;
    public function getPrototype() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberReflection;
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array;
    public function isDeprecated() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isFinal() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function isInternal() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
    public function getThrowType() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function hasSideEffects() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
}
