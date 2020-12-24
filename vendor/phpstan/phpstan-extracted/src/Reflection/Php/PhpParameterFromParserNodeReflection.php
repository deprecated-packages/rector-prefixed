<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Php;

use _PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypehintHelper;
class PhpParameterFromParserNodeReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflectionWithPhpDocs
{
    /** @var string */
    private $name;
    /** @var bool */
    private $optional;
    /** @var \PHPStan\Type\Type */
    private $realType;
    /** @var \PHPStan\Type\Type|null */
    private $phpDocType;
    /** @var \PHPStan\Reflection\PassedByReference */
    private $passedByReference;
    /** @var \PHPStan\Type\Type|null */
    private $defaultValue;
    /** @var bool */
    private $variadic;
    /** @var \PHPStan\Type\Type|null */
    private $type = null;
    public function __construct(string $name, bool $optional, \_PhpScopere8e811afab72\PHPStan\Type\Type $realType, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $phpDocType, \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference $passedByReference, ?\_PhpScopere8e811afab72\PHPStan\Type\Type $defaultValue, bool $variadic)
    {
        $this->name = $name;
        $this->optional = $optional;
        $this->realType = $realType;
        $this->phpDocType = $phpDocType;
        $this->passedByReference = $passedByReference;
        $this->defaultValue = $defaultValue;
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
    public function getType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($this->type === null) {
            $phpDocType = $this->phpDocType;
            if ($phpDocType !== null && $this->defaultValue !== null) {
                if ($this->defaultValue instanceof \_PhpScopere8e811afab72\PHPStan\Type\NullType) {
                    $phpDocType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::addNull($phpDocType);
                }
            }
            $this->type = \_PhpScopere8e811afab72\PHPStan\Type\TypehintHelper::decideType($this->realType, $phpDocType);
        }
        return $this->type;
    }
    public function getPhpDocType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->phpDocType ?? new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    public function getNativeType() : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->realType;
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
}
