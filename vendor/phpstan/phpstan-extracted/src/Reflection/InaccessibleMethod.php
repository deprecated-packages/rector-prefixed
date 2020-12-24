<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
class InaccessibleMethod implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptor
{
    /** @var MethodReflection */
    private $methodReflection;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection $methodReflection)
    {
        $this->methodReflection = $methodReflection;
    }
    public function getMethod() : \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
    {
        return $this->methodReflection;
    }
    public function getTemplateTypeMap() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    public function getResolvedTemplateTypeMap() : \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateTypeMap::createEmpty();
    }
    /**
     * @return array<int, \PHPStan\Reflection\ParameterReflection>
     */
    public function getParameters() : array
    {
        return [];
    }
    public function isVariadic() : bool
    {
        return \true;
    }
    public function getReturnType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
    }
}
