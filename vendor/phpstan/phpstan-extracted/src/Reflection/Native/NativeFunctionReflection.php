<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Native;

use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class NativeFunctionReflection implements \RectorPrefix20201227\PHPStan\Reflection\FunctionReflection
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
    public function __construct(string $name, array $variants, ?\PHPStan\Type\Type $throwType, \RectorPrefix20201227\PHPStan\TrinaryLogic $hasSideEffects)
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
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return $this->throwType;
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function isFinal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function hasSideEffects() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->hasSideEffects;
    }
    public function isBuiltin() : bool
    {
        return \true;
    }
}
