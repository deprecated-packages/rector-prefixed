<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Native;

use _PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflectionWithPhpDocs;
use _PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class NativeParameterWithPhpDocsReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflectionWithPhpDocs
{
    /** @var string */
    private $name;
    /** @var bool */
    private $optional;
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var \PHPStan\Type\Type */
    private $phpDocType;
    /** @var \PHPStan\Type\Type */
    private $nativeType;
    /** @var \PHPStan\Reflection\PassedByReference */
    private $passedByReference;
    /** @var bool */
    private $variadic;
    /** @var \PHPStan\Type\Type|null */
    private $defaultValue;
    public function __construct(string $name, bool $optional, \_PhpScopere8e811afab72\PHPStan\Type\Type $type, \_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocType, \_PhpScopere8e811afab72\PHPStan\Type\Type $nativeType, \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference $passedByReference, bool $variadic, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $defaultValue)
    {
        $this->name = $name;
        $this->optional = $optional;
        $this->type = $type;
        $this->phpDocType = $phpDocType;
        $this->nativeType = $nativeType;
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
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function getPhpDocType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->phpDocType;
    }
    public function getNativeType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->nativeType;
    }
    public function passedByReference() : \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    public function getDefaultValue() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->defaultValue;
    }
    /**
     * @param mixed[] $properties
     * @return self
     */
    public static function __set_state(array $properties) : self
    {
        return new self($properties['name'], $properties['optional'], $properties['type'], $properties['phpDocType'], $properties['nativeType'], $properties['passedByReference'], $properties['variadic'], $properties['defaultValue']);
    }
}
