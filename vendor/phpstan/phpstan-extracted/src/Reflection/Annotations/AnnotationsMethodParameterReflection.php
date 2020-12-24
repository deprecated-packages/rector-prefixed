<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Annotations;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class AnnotationsMethodParameterReflection implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflection
{
    /** @var string */
    private $name;
    /** @var Type */
    private $type;
    /** @var \PHPStan\Reflection\PassedByReference */
    private $passedByReference;
    /** @var bool */
    private $isOptional;
    /** @var bool */
    private $isVariadic;
    /** @var Type|null */
    private $defaultValue;
    public function __construct(string $name, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference $passedByReference, bool $isOptional, bool $isVariadic, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $defaultValue)
    {
        $this->name = $name;
        $this->type = $type;
        $this->passedByReference = $passedByReference;
        $this->isOptional = $isOptional;
        $this->isVariadic = $isVariadic;
        $this->defaultValue = $defaultValue;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function isOptional() : bool
    {
        return $this->isOptional;
    }
    public function getType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->type;
    }
    public function passedByReference() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PassedByReference
    {
        return $this->passedByReference;
    }
    public function isVariadic() : bool
    {
        return $this->isVariadic;
    }
    public function getDefaultValue() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->defaultValue;
    }
}
