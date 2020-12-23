<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PassedByReference;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper;
class PhpParameterFromParserNodeReflection implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParameterReflectionWithPhpDocs
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
    public function __construct(string $name, bool $optional, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $realType, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $phpDocType, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PassedByReference $passedByReference, ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $defaultValue, bool $variadic)
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
    public function getType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($this->type === null) {
            $phpDocType = $this->phpDocType;
            if ($phpDocType !== null && $this->defaultValue !== null) {
                if ($this->defaultValue instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType) {
                    $phpDocType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::addNull($phpDocType);
                }
            }
            $this->type = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypehintHelper::decideType($this->realType, $phpDocType);
        }
        return $this->type;
    }
    public function getPhpDocType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->phpDocType ?? new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
    public function getNativeType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->realType;
    }
    public function passedByReference() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    public function getDefaultValue() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->defaultValue;
    }
}
