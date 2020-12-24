<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflectionWithPhpDocs;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantTypeHelper;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypehintHelper;
class PhpParameterReflection implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflectionWithPhpDocs
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
    public function __construct(\ReflectionParameter $reflection, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $phpDocType, ?string $declaringClassName)
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
    public function getType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($this->type === null) {
            $phpDocType = $this->phpDocType;
            if ($phpDocType !== null) {
                try {
                    if ($this->reflection->isDefaultValueAvailable() && $this->reflection->getDefaultValue() === null) {
                        $phpDocType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::addNull($phpDocType);
                    }
                } catch (\Throwable $e) {
                    // pass
                }
            }
            $this->type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getType(), $phpDocType, $this->declaringClassName, $this->isVariadic());
        }
        return $this->type;
    }
    public function passedByReference() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference
    {
        return $this->reflection->isPassedByReference() ? \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference::createCreatesNewVariable() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference::createNo();
    }
    public function isVariadic() : bool
    {
        return $this->reflection->isVariadic();
    }
    public function getPhpDocType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($this->phpDocType !== null) {
            return $this->phpDocType;
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
    }
    public function getNativeType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($this->nativeType === null) {
            $this->nativeType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypehintHelper::decideTypeFromReflection($this->reflection->getType(), null, $this->declaringClassName, $this->isVariadic());
        }
        return $this->nativeType;
    }
    public function getDefaultValue() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        try {
            if ($this->reflection->isDefaultValueAvailable()) {
                $defaultValue = $this->reflection->getDefaultValue();
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($defaultValue);
            }
        } catch (\Throwable $e) {
            return null;
        }
        return null;
    }
}
