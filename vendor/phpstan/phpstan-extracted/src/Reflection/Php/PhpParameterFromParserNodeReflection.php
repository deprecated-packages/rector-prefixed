<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Php;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper;
class PhpParameterFromParserNodeReflection implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflectionWithPhpDocs
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
    public function __construct(string $name, bool $optional, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $realType, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $phpDocType, \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference $passedByReference, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $defaultValue, bool $variadic)
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
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($this->type === null) {
            $phpDocType = $this->phpDocType;
            if ($phpDocType !== null && $this->defaultValue !== null) {
                if ($this->defaultValue instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
                    $phpDocType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::addNull($phpDocType);
                }
            }
            $this->type = \_PhpScoperb75b35f52b74\PHPStan\Type\TypehintHelper::decideType($this->realType, $phpDocType);
        }
        return $this->type;
    }
    public function getPhpDocType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->phpDocType ?? new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    public function getNativeType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->realType;
    }
    public function passedByReference() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
    public function getDefaultValue() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->defaultValue;
    }
}
