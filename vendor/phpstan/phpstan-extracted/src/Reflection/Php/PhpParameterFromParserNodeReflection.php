<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypehintHelper;
class PhpParameterFromParserNodeReflection implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflectionWithPhpDocs
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
    public function __construct(string $name, bool $optional, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $realType, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $phpDocType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference $passedByReference, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $defaultValue, bool $variadic)
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
    public function getType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($this->type === null) {
            $phpDocType = $this->phpDocType;
            if ($phpDocType !== null && $this->defaultValue !== null) {
                if ($this->defaultValue instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NullType) {
                    $phpDocType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::addNull($phpDocType);
                }
            }
            $this->type = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypehintHelper::decideType($this->realType, $phpDocType);
        }
        return $this->type;
    }
    public function getPhpDocType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->phpDocType ?? new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
    }
    public function getNativeType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->realType;
    }
    public function passedByReference() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    public function getDefaultValue() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->defaultValue;
    }
}
