<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Php;

use RectorPrefix20201227\PHPStan\Reflection\ParameterReflection;
use RectorPrefix20201227\PHPStan\Reflection\PassedByReference;
use PHPStan\Type\Type;
class DummyParameter implements \RectorPrefix20201227\PHPStan\Reflection\ParameterReflection
{
    /** @var string */
    private $name;
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $optional;
    /** @var \PHPStan\Reflection\PassedByReference */
    private $passedByReference;
    /** @var bool */
    private $variadic;
    /** @var ?\PHPStan\Type\Type */
    private $defaultValue;
    public function __construct(string $name, \PHPStan\Type\Type $type, bool $optional, ?\RectorPrefix20201227\PHPStan\Reflection\PassedByReference $passedByReference, bool $variadic, ?\PHPStan\Type\Type $defaultValue)
    {
        $this->name = $name;
        $this->type = $type;
        $this->optional = $optional;
        $this->passedByReference = $passedByReference ?? \RectorPrefix20201227\PHPStan\Reflection\PassedByReference::createNo();
        $this->variadic = $variadic;
        $this->defaultValue = $defaultValue;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function isOptional() : bool
    {
        return $this->optional;
    }
    public function getType() : \PHPStan\Type\Type
    {
        return $this->type;
    }
    public function passedByReference() : \RectorPrefix20201227\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    public function getDefaultValue() : ?\PHPStan\Type\Type
    {
        return $this->defaultValue;
    }
}
