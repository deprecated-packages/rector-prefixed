<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\SignatureMap;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class ParameterSignature
{
    /** @var string */
    private $name;
    /** @var bool */
    private $optional;
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var \PHPStan\Type\Type */
    private $nativeType;
    /** @var \PHPStan\Reflection\PassedByReference */
    private $passedByReference;
    /** @var bool */
    private $variadic;
    public function __construct(string $name, bool $optional, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $nativeType, \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference $passedByReference, bool $variadic)
    {
        $this->name = $name;
        $this->optional = $optional;
        $this->type = $type;
        $this->nativeType = $nativeType;
        $this->passedByReference = $passedByReference;
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
        return $this->type;
    }
    public function getNativeType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->nativeType;
    }
    public function passedByReference() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
}
