<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
interface MethodReflection extends \RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection
{
    public function getName() : string;
    public function getPrototype() : \RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection;
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array;
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getDeprecatedDescription() : ?string;
    public function isFinal() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
    public function getThrowType() : ?\PHPStan\Type\Type;
    public function hasSideEffects() : \RectorPrefix20201227\PHPStan\TrinaryLogic;
}
