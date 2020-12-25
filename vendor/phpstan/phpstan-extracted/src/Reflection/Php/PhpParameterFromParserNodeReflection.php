<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Php;

use PHPStan\Reflection\PassedByReference;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use PHPStan\Type\TypehintHelper;
class PhpParameterFromParserNodeReflection implements \PHPStan\Reflection\ParameterReflectionWithPhpDocs
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
    public function __construct(string $name, bool $optional, \PHPStan\Type\Type $realType, ?\PHPStan\Type\Type $phpDocType, \PHPStan\Reflection\PassedByReference $passedByReference, ?\PHPStan\Type\Type $defaultValue, bool $variadic)
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
    public function getType() : \PHPStan\Type\Type
    {
        if ($this->type === null) {
            $phpDocType = $this->phpDocType;
            if ($phpDocType !== null && $this->defaultValue !== null) {
                if ($this->defaultValue instanceof \PHPStan\Type\NullType) {
                    $phpDocType = \PHPStan\Type\TypeCombinator::addNull($phpDocType);
                }
            }
            $this->type = \PHPStan\Type\TypehintHelper::decideType($this->realType, $phpDocType);
        }
        return $this->type;
    }
    public function getPhpDocType() : \PHPStan\Type\Type
    {
        return $this->phpDocType ?? new \PHPStan\Type\MixedType();
    }
    public function getNativeType() : \PHPStan\Type\Type
    {
        return $this->realType;
    }
    public function passedByReference() : \PHPStan\Reflection\PassedByReference
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
