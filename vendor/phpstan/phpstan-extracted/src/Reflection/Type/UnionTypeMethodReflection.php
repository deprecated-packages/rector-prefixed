<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\Type;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionVariant;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
class UnionTypeMethodReflection implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
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
    public function getDeclaringClass() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
    {
        return $this->methods[0]->getDeclaringClass();
    }
    public function isStatic() : bool
    {
        foreach ($this->methods as $method) {
            if (!$method->isStatic()) {
                return \false;
            }
        }
        return \true;
    }
    public function isPrivate() : bool
    {
        foreach ($this->methods as $method) {
            if ($method->isPrivate()) {
                return \true;
            }
        }
        return \false;
    }
    public function isPublic() : bool
    {
        foreach ($this->methods as $method) {
            if (!$method->isPublic()) {
                return \false;
            }
        }
        return \true;
    }
    public function getName() : string
    {
        return $this->methodName;
    }
    public function getPrototype() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    public function getVariants() : array
    {
        $variants = $this->methods[0]->getVariants();
        $returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $method) : Type {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor $acceptor) : Type {
                return $acceptor->getReturnType();
            }, $method->getVariants()));
        }, $this->methods));
        return \array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptor $acceptor) use($returnType) : ParametersAcceptor {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionVariant($acceptor->getTemplateTypeMap(), $acceptor->getResolvedTemplateTypeMap(), $acceptor->getParameters(), $acceptor->isVariadic(), $returnType);
        }, $variants);
    }
    public function isDeprecated() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::extremeIdentity(...\array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
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
    public function isFinal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::extremeIdentity(...\array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
            return $method->isFinal();
        }, $this->methods));
    }
    public function isInternal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::extremeIdentity(...\array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
            return $method->isInternal();
        }, $this->methods));
    }
    public function getThrowType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
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
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$types);
    }
    public function hasSideEffects() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::extremeIdentity(...\array_map(static function (\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
            return $method->hasSideEffects();
        }, $this->methods));
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
