<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\SignatureMap;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class ParameterSignature
{
    /** @var string */
    private $name;
    /** @var bool */
    private $optional;
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var \PHPStan\Type\Type */
    private $nativeType;
    /** @var \PHPStan\Reflection\PassedByReference */
    private $passedByReference;
    /** @var bool */
    private $variadic;
    public function __construct(string $name, bool $optional, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $nativeType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference $passedByReference, bool $variadic)
    {
        $this->name = $name;
        $this->optional = $optional;
        $this->type = $type;
        $this->nativeType = $nativeType;
        $this->passedByReference = $passedByReference;
        $this->variadic = $variadic;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function isOptional() : bool
    {
        return $this->optional;
    }
    public function getType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getNativeType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->nativeType;
    }
    public function passedByReference() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
}
