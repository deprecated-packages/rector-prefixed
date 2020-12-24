<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\SignatureMap;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class FunctionSignature
{
    /** @var \PHPStan\Reflection\SignatureMap\ParameterSignature[] */
    private $parameters;
    /** @var \PHPStan\Type\Type */
    private $returnType;
    /** @var \PHPStan\Type\Type */
    private $nativeReturnType;
    /** @var bool */
    private $variadic;
    /**
     * @param array<int, \PHPStan\Reflection\SignatureMap\ParameterSignature> $parameters
     * @param \PHPStan\Type\Type $returnType
     * @param \PHPStan\Type\Type $nativeReturnType
     * @param bool $variadic
     */
    public function __construct(array $parameters, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $returnType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $nativeReturnType, bool $variadic)
    {
        $this->parameters = $parameters;
        $this->returnType = $returnType;
        $this->nativeReturnType = $nativeReturnType;
        $this->variadic = $variadic;
    }
    /**
     * @return array<int, \PHPStan\Reflection\SignatureMap\ParameterSignature>
     */
    public function getParameters() : array
    {
        return $this->parameters;
    }
    public function getReturnType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->returnType;
    }
    public function getNativeReturnType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return $this->nativeReturnType;
    }
    public function isVariadic() : bool
    {
        return $this->variadic;
    }
}
