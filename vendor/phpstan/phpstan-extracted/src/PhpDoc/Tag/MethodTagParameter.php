<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\PhpDoc\Tag;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\PassedByReference;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
class MethodTagParameter
{
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var \PHPStan\Reflection\PassedByReference */
    private $passedByReference;
    /** @var bool */
    private $isOptional;
    /** @var bool */
    private $isVariadic;
    /** @var \PHPStan\Type\Type|null */
    private $defaultValue;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, \_PhpScoper0a6b37af0871\PHPStan\Reflection\PassedByReference $passedByReference, bool $isOptional, bool $isVariadic, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $defaultValue)
    {
        $this->type = $type;
        $this->passedByReference = $passedByReference;
        $this->isOptional = $isOptional;
        $this->isVariadic = $isVariadic;
        $this->defaultValue = $defaultValue;
    }
    public function getType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function passedByReference() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isOptional() : bool
    {
        return $this->isOptional;
    }
    public function isVariadic() : bool
    {
        return $this->isVariadic;
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
        return new self($properties['type'], $properties['passedByReference'], $properties['isOptional'], $properties['isVariadic'], $properties['defaultValue']);
    }
}
