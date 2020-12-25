<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Php;

use PHPStan\Reflection\ParameterReflectionWithPhpDocs;
use PHPStan\Reflection\PassedByReference;
use PHPStan\Type\ConstantTypeHelper;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypehintHelper;
class PhpParameterReflection implements \PHPStan\Reflection\ParameterReflectionWithPhpDocs
{
    /** @var \ReflectionParameter */
    private $reflection;
    /** @var \PHPStan\Type\Type|null */
    private $phpDocType;
    /** @var \PHPStan\Type\Type|null */
    private $type = null;
    /** @var \PHPStan\Type\Type|null */
    private $nativeType = null;
    /** @var string|null */
    private $declaringClassName;
    public function __construct(\ReflectionParameter $reflection, ?\PHPStan\Type\Type $phpDocType, ?string $declaringClassName)
    {
        $this->reflection = $reflection;
        $this->phpDocType = $phpDocType;
        $this->declaringClassName = $declaringClassName;
    }
    public function isOptional() : bool
    {
        return $this->reflection->isOptional();
    }
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getType() : \PHPStan\Type\Type
    {
        if ($this->type === null) {
            $phpDocType = $this->phpDocType;
            if ($phpDocType !== null) {
                try {
                    if ($this->reflection->isDefaultValueAvailable() && $this->reflection->getDefaultValue() === null) {
                        $phpDocType = \PHPStan\Type\TypeCombinator::addNull($phpDocType);
                    }
                } catch (\Throwable $e) {
                    // pass
                }
            }
            $this->type = \PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getType(), $phpDocType, $this->declaringClassName, $this->isVariadic());
        }
        return $this->type;
    }
    public function passedByReference() : \PHPStan\Reflection\PassedByReference
    {
        return $this->reflection->isPassedByReference() ? \PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \PHPStan\Reflection\PassedByReference::createNo();
    }
    public function isVariadic() : bool
    {
        return $this->reflection->isVariadic();
    }
    public function getPhpDocType() : \PHPStan\Type\Type
    {
        if ($this->phpDocType !== null) {
            return $this->phpDocType;
        }
        return new \PHPStan\Type\MixedType();
    }
    public function getNativeType() : \PHPStan\Type\Type
    {
        if ($this->nativeType === null) {
            $this->nativeType = \PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getType(), null, $this->declaringClassName, $this->isVariadic());
        }
        return $this->nativeType;
    }
    public function getDefaultValue() : ?\PHPStan\Type\Type
    {
        try {
            if ($this->reflection->isDefaultValueAvailable()) {
                $defaultValue = $this->reflection->getDefaultValue();
                return \PHPStan\Type\ConstantTypeHelper::getTypeFromValue($defaultValue);
            }
        } catch (\Throwable $e) {
            return null;
        }
        return null;
    }
}
