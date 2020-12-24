<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\Native;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParameterReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\PassedByReference;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
class NativeParameterReflection implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParameterReflection
{
    /** @var string */
    private $name;
    /** @var bool */
    private $optional;
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var \PHPStan\Reflection\PassedByReference */
    private $passedByReference;
    /** @var bool */
    private $variadic;
    /** @var \PHPStan\Type\Type|null */
    private $defaultValue;
    public function __construct(string $name, bool $optional, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, \_PhpScoper0a6b37af0871\PHPStan\Reflection\PassedByReference $passedByReference, bool $variadic, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $defaultValue)
    {
        $this->name = $name;
        $this->optional = $optional;
        $this->type = $type;
        $this->passedByReference = $passedByReference;
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
    public function getType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function passedByReference() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    public function getDefaultValue() : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->defaultValue;
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['name'], $properties['optional'], $properties['type'], $properties['passedByReference'], $properties['variadic'], $properties['defaultValue']);
    }
}
