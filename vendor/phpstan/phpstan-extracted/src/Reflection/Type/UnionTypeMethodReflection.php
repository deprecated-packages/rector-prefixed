<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Type;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionVariant;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
class UnionTypeMethodReflection implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
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
    public function getDeclaringClass() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    public function getVariants() : array
    {
        $variants = $this->methods[0]->getVariants();
        $returnType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $method) : Type {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...\array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor $acceptor) : Type {
                return $acceptor->getReturnType();
            }, $method->getVariants()));
        }, $this->methods));
        return \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor $acceptor) use($returnType) : ParametersAcceptor {
            return new \_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionVariant($acceptor->getTemplateTypeMap(), $acceptor->getResolvedTemplateTypeMap(), $acceptor->getParameters(), $acceptor->isVariadic(), $returnType);
        }, $variants);
    }
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::extremeIdentity(...\array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
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
    public function isFinal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::extremeIdentity(...\array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
            return $method->isFinal();
        }, $this->methods));
    }
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::extremeIdentity(...\array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
            return $method->isInternal();
        }, $this->methods));
    }
    public function getThrowType() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
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
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$types);
    }
    public function hasSideEffects() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::extremeIdentity(...\array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $method) : TrinaryLogic {
            return $method->hasSideEffects();
        }, $this->methods));
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
