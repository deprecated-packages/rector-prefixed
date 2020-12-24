<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Php;

use _PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflectionWithPhpDocs;
use _PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypehintHelper;
class PhpParameterReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflectionWithPhpDocs
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
    public function __construct(\ReflectionParameter $reflection, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocType, ?string $declaringClassName)
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
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->type === null) {
            $phpDocType = $this->phpDocType;
            if ($phpDocType !== null) {
                try {
                    if ($this->reflection->isDefaultValueAvailable() && $this->reflection->getDefaultValue() === null) {
                        $phpDocType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::addNull($phpDocType);
                    }
                } catch (\Throwable $e) {
                    // pass
                }
            }
            $this->type = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getType(), $phpDocType, $this->declaringClassName, $this->isVariadic());
        }
        return $this->type;
    }
    public function passedByReference() : \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference
    {
        return $this->reflection->isPassedByReference() ? \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference::createNo();
    }
    public function isVariadic() : bool
    {
        return $this->reflection->isVariadic();
    }
    public function getPhpDocType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->phpDocType !== null) {
            return $this->phpDocType;
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    public function getNativeType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->nativeType === null) {
            $this->nativeType = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getType(), null, $this->declaringClassName, $this->isVariadic());
        }
        return $this->nativeType;
    }
    public function getDefaultValue() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        try {
            if ($this->reflection->isDefaultValueAvailable()) {
                $defaultValue = $this->reflection->getDefaultValue();
                return \_PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($defaultValue);
            }
        } catch (\Throwable $e) {
            return null;
        }
        return null;
    }
}
