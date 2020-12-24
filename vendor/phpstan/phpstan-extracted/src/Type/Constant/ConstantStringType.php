<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\InaccessibleMethod;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
class ConstantStringType extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantScalarType
{
    private const DESCRIBE_LIMIT = 20;
    use ConstantScalarTypeTrait;
    use ConstantScalarToBooleanTrait;
    /** @var string */
    private $value;
    /** @var bool */
    private $isClassString;
    public function __construct(string $value, bool $isClassString = \false)
    {
        $this->value = $value;
        $this->isClassString = $isClassString;
    }
    public function getValue() : string
    {
        return $this->value;
    }
    public function isClassString() : bool
    {
        return $this->isClassString;
    }
    public function describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'string';
        }, function () : string {
            if ($this->isClassString) {
                return \var_export($this->value, \true);
            }
            try {
                $truncatedValue = \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::truncate($this->value, self::DESCRIBE_LIMIT);
            } catch (\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\RegexpException $e) {
                $truncatedValue = \substr($this->value, 0, self::DESCRIBE_LIMIT) . "…";
            }
            return \var_export($truncatedValue, \true);
        }, function () : string {
            return \var_export($this->value, \true);
        });
    }
    public function isSuperTypeOf(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType) {
            $genericType = $type->getGenericType();
            if ($genericType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
            }
            if ($genericType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType) {
                $genericType = $genericType->getStaticObjectType();
            }
            // We are transforming constant class-string to ObjectType. But we need to filter out
            // an uncertainty originating in possible ObjectType's class subtypes.
            $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($this->getValue());
            // Do not use TemplateType's isSuperTypeOf handling directly because it takes ObjectType
            // uncertainty into account.
            if ($genericType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType) {
                $isSuperType = $genericType->getBound()->isSuperTypeOf($objectType);
            } else {
                $isSuperType = $genericType->isSuperTypeOf($objectType);
            }
            // Explicitly handle the uncertainty for Yes & Maybe.
            if ($isSuperType->yes()) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType) {
            $broker = \_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker::getInstance();
            return $broker->hasClass($this->getValue()) ? \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof self) {
            return $this->value === $type->value ? \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function isCallable() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($this->value === '') {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
        }
        $broker = \_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker::getInstance();
        // 'my_function'
        if ($broker->hasFunction(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($this->value), null)) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
        }
        // 'MyClass::myStaticFunction'
        $matches = \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($this->value, '#^([a-zA-Z_\\x7f-\\xff\\\\][a-zA-Z0-9_\\x7f-\\xff\\\\]*)::([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)\\z#');
        if ($matches !== null) {
            if (!$broker->hasClass($matches[1])) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
            }
            $classRef = $broker->getClass($matches[1]);
            if ($classRef->hasMethod($matches[2])) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createYes();
            }
            if (!$classRef->getNativeReflection()->isFinal()) {
                return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        $broker = \_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker::getInstance();
        // 'my_function'
        $functionName = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name($this->value);
        if ($broker->hasFunction($functionName, null)) {
            return $broker->getFunction($functionName, null)->getVariants();
        }
        // 'MyClass::myStaticFunction'
        $matches = \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($this->value, '#^([a-zA-Z_\\x7f-\\xff\\\\][a-zA-Z0-9_\\x7f-\\xff\\\\]*)::([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)\\z#');
        if ($matches !== null) {
            if (!$broker->hasClass($matches[1])) {
                return [new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\TrivialParametersAcceptor()];
            }
            $classReflection = $broker->getClass($matches[1]);
            if ($classReflection->hasMethod($matches[2])) {
                $method = $classReflection->getMethod($matches[2], $scope);
                if (!$scope->canCallMethod($method)) {
                    return [new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\InaccessibleMethod($method)];
                }
                return $method->getVariants();
            }
            if (!$classReflection->getNativeReflection()->isFinal()) {
                return [new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\TrivialParametersAcceptor()];
            }
        }
        throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
    }
    public function toNumber() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if (\is_numeric($this->value)) {
            /** @var mixed $value */
            $value = $this->value;
            $value = +$value;
            if (\is_float($value)) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType($value);
            }
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType($value);
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $type = $this->toNumber();
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
            return $type;
        }
        return $type->toInteger();
    }
    public function toFloat() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $type = $this->toNumber();
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
            return $type;
        }
        return $type->toFloat();
    }
    public function isNumericString() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createFromBoolean(\is_numeric($this->getValue()));
    }
    public function hasOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        if ($offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createFromBoolean($offsetType->getValue() < \strlen($this->value));
        }
        return parent::hasOffsetValueType($offsetType);
    }
    public function getOffsetValueType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType) {
            if ($offsetType->getValue() < \strlen($this->value)) {
                return new self($this->value[$offsetType->getValue()]);
            }
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
        }
        return parent::getOffsetValueType($offsetType);
    }
    public function setOffsetValueType(?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $offsetType, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $valueType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $valueStringType = $valueType->toString();
        if ($valueStringType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
        }
        if ($offsetType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType && $valueStringType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
            $value = $this->value;
            $value[$offsetType->getValue()] = $valueStringType->getValue();
            return new self($value);
        }
        return parent::setOffsetValueType($offsetType, $valueType);
    }
    public function append(self $otherString) : self
    {
        return new self($this->getValue() . $otherString->getValue());
    }
    public function generalize() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($this->isClassString) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType();
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new self($properties['value'], $properties['isClassString'] ?? \false);
    }
}
