<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Php;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class DummyParameter implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection
{
    /** @var string */
    private $name;
    /** @var \PHPStan\Type\Type */
    private $type;
    /** @var bool */
    private $optional;
    /** @var \PHPStan\Reflection\PassedByReference */
    private $passedByReference;
    /** @var bool */
    private $variadic;
    /** @var ?\PHPStan\Type\Type */
    private $defaultValue;
    public function __construct(string $name, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, bool $optional, ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference $passedByReference, bool $variadic, ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $defaultValue)
    {
        $this->name = $name;
        $this->type = $type;
        $this->optional = $optional;
        $this->passedByReference = $passedByReference ?? \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference::createNo();
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
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->type;
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
