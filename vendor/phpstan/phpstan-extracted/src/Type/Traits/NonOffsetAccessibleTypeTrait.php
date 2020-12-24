<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits;

use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
trait NonOffsetAccessibleTypeTrait
{
    public function isOffsetAccessible() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function hasOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function getOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
    }
    public function setOffsetValueType(?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $valueType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this;
    }
}
