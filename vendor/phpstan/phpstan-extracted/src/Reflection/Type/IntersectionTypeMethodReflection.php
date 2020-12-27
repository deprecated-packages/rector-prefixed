<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Type;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\FunctionVariant;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class IntersectionTypeMethodReflection implements \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
{
    /** @var string */
    private $methodName;
    /** @var MethodReflection[] */
    private $methods;
    /**
     * @param string $methodName
     * @param \PHPStan\Reflection\MethodReflection[] $methods
     */
    public function __construct(string $methodName, array $methods)
    {
        $this->methodName = $methodName;
        $this->methods = $methods;
    }
    public function getDeclaringClass() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        return $this->methods[0]->getDeclaringClass();
    }
    public function isStatic() : bool
    {
        foreach ($this->methods as $method) {
            if ($method->isStatic()) {
                return \true;
            }
        }
        return \false;
    }
    public function isPrivate() : bool
    {
        foreach ($this->methods as $method) {
            if (!$method->isPrivate()) {
                return \false;
            }
        }
        return \true;
    }
    public function isPublic() : bool
    {
        foreach ($this->methods as $method) {
            if ($method->isPublic()) {
                return \true;
            }
        }
        return \false;
    }
    public function getName() : string
    {
        return $this->methodName;
    }
    public function getPrototype() : \RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    public function getVariants() : array
    {
        $variants = $this->methods[0]->getVariants();
        $returnType = \PHPStan\Type\TypeCombinator::intersect(...\array_map(static function (\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $method) : Type {
            return \PHPStan\Type\TypeCombinator::intersect(...\array_map(static function (\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor $acceptor) : Type {
                return $acceptor->getReturnType();
            }, $method->getVariants()));
        }, $this->methods));
        return \array_map(static function (\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor $acceptor) use($returnType) : ParametersAcceptor {
            return new \RectorPrefix20201227\PHPStan\Reflection\FunctionVariant($acceptor->getTemplateTypeMap(), $acceptor->getResolvedTemplateTypeMap(), $acceptor->getParameters(), $acceptor->isVariadic(), $returnType);
        }, $variants);
    }
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::maxMin(...\array_map(static function (\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
            return $method->isDeprecated();
        }, $this->methods));
    }
    public function getDeprecatedDescription() : ?string
    {
        $descriptions = [];
        foreach ($this->methods as $method) {
            if (!$method->isDeprecated()->yes()) {
                continue;
            }
            $description = $method->getDeprecatedDescription();
            if ($description === null) {
                continue;
            }
            $descriptions[] = $description;
        }
        if (\count($descriptions) === 0) {
            return null;
        }
        return \implode(' ', $descriptions);
    }
    public function isFinal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::maxMin(...\array_map(static function (\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
            return $method->isFinal();
        }, $this->methods));
    }
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::maxMin(...\array_map(static function (\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
            return $method->isInternal();
        }, $this->methods));
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        $types = [];
        foreach ($this->methods as $method) {
            $type = $method->getThrowType();
            if ($type === null) {
                continue;
            }
            $types[] = $type;
        }
        if (\count($types) === 0) {
            return null;
        }
        return \PHPStan\Type\TypeCombinator::intersect(...$types);
    }
    public function hasSideEffects() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::maxMin(...\array_map(static function (\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
            return $method->hasSideEffects();
        }, $this->methods));
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
