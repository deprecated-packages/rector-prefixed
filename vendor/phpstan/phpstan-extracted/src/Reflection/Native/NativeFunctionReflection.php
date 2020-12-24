<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection\Native;

use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
class NativeFunctionReflection implements \_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection
{
    /** @var string */
    private $name;
    /** @var \PHPStan\Reflection\ParametersAcceptor[] */
    private $variants;
    /** @var \PHPStan\Type\Type|null */
    private $throwType;
    /** @var TrinaryLogic */
    private $hasSideEffects;
    /**
     * @param string $name
     * @param \PHPStan\Reflection\ParametersAcceptor[] $variants
     * @param \PHPStan\Type\Type|null $throwType
     * @param \PHPStan\TrinaryLogic $hasSideEffects
     */
    public function __construct(string $name, array $variants, ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $throwType, \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic $hasSideEffects)
    {
        $this->name = $name;
        $this->variants = $variants;
        $this->throwType = $throwType;
        $this->hasSideEffects = $hasSideEffects;
    }
    public function getName() : string
    {
        return $this->name;
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        return $this->variants;
    }
    public function getThrowType() : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        return $this->throwType;
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isDeprecated() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function isInternal() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function isFinal() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createNo();
    }
    public function hasSideEffects() : \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic
    {
        return $this->hasSideEffects;
    }
    public function isBuiltin() : bool
    {
        return \true;
    }
}
