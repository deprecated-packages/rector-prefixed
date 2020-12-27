<?php

declare (strict_types=1);
namespace PHPStan\Type\Constant;

use PhpParser\Node\Name;
use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\InaccessibleMethod;
use RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\CompoundType;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\Generic\TemplateType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StaticType;
use PHPStan\Type\StringType;
use PHPStan\Type\Traits\ConstantScalarTypeTrait;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
class ConstantStringType extends \PHPStan\Type\StringType implements \PHPStan\Type\ConstantScalarType
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
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'string';
        }, function () : string {
            if ($this->isClassString) {
                return \var_export($this->value, \true);
            }
            try {
                $truncatedValue = \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::truncate($this->value, self::DESCRIBE_LIMIT);
            } catch (\RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Utils\RegexpException $e) {
                $truncatedValue = \substr($this->value, 0, self::DESCRIBE_LIMIT) . "…";
            }
            return \var_export($truncatedValue, \true);
        }, function () : string {
            return \var_export($this->value, \true);
        });
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($type instanceof \PHPStan\Type\Generic\GenericClassStringType) {
            $genericType = $type->getGenericType();
            if ($genericType instanceof \PHPStan\Type\MixedType) {
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
            }
            if ($genericType instanceof \PHPStan\Type\StaticType) {
                $genericType = $genericType->getStaticObjectType();
            }
            // We are transforming constant class-string to ObjectType. But we need to filter out
            // an uncertainty originating in possible ObjectType's class subtypes.
            $objectType = new \PHPStan\Type\ObjectType($this->getValue());
            // Do not use TemplateType's isSuperTypeOf handling directly because it takes ObjectType
            // uncertainty into account.
            if ($genericType instanceof \PHPStan\Type\Generic\TemplateType) {
                $isSuperType = $genericType->getBound()->isSuperTypeOf($objectType);
            } else {
                $isSuperType = $genericType->isSuperTypeOf($objectType);
            }
            // Explicitly handle the uncertainty for Yes & Maybe.
            if ($isSuperType->yes()) {
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
            }
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof \PHPStan\Type\ClassStringType) {
            $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
            return $broker->hasClass($this->getValue()) ? \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe() : \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof self) {
            return $this->value === $type->value ? \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes() : \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function isCallable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($this->value === '') {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
        // 'my_function'
        if ($broker->hasFunction(new \PhpParser\Node\Name($this->value), null)) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        // 'MyClass::myStaticFunction'
        $matches = \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($this->value, '#^([a-zA-Z_\\x7f-\\xff\\\\][a-zA-Z0-9_\\x7f-\\xff\\\\]*)::([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)\\z#');
        if ($matches !== null) {
            if (!$broker->hasClass($matches[1])) {
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
            }
            $classRef = $broker->getClass($matches[1]);
            if ($classRef->hasMethod($matches[2])) {
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
            }
            if (!$classRef->getNativeReflection()->isFinal()) {
                return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
            }
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
        // 'my_function'
        $functionName = new \PhpParser\Node\Name($this->value);
        if ($broker->hasFunction($functionName, null)) {
            return $broker->getFunction($functionName, null)->getVariants();
        }
        // 'MyClass::myStaticFunction'
        $matches = \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($this->value, '#^([a-zA-Z_\\x7f-\\xff\\\\][a-zA-Z0-9_\\x7f-\\xff\\\\]*)::([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)\\z#');
        if ($matches !== null) {
            if (!$broker->hasClass($matches[1])) {
                return [new \RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor()];
            }
            $classReflection = $broker->getClass($matches[1]);
            if ($classReflection->hasMethod($matches[2])) {
                $method = $classReflection->getMethod($matches[2], $scope);
                if (!$scope->canCallMethod($method)) {
                    return [new \RectorPrefix20201227\PHPStan\Reflection\InaccessibleMethod($method)];
                }
                return $method->getVariants();
            }
            if (!$classReflection->getNativeReflection()->isFinal()) {
                return [new \RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor()];
            }
        }
        throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
    }
    public function toNumber() : \PHPStan\Type\Type
    {
        if (\is_numeric($this->value)) {
            /** @var mixed $value */
            $value = $this->value;
            $value = +$value;
            if (\is_float($value)) {
                return new \PHPStan\Type\Constant\ConstantFloatType($value);
            }
            return new \PHPStan\Type\Constant\ConstantIntegerType($value);
        }
        return new \PHPStan\Type\ErrorType();
    }
    public function toInteger() : \PHPStan\Type\Type
    {
        $type = $this->toNumber();
        if ($type instanceof \PHPStan\Type\ErrorType) {
            return $type;
        }
        return $type->toInteger();
    }
    public function toFloat() : \PHPStan\Type\Type
    {
        $type = $this->toNumber();
        if ($type instanceof \PHPStan\Type\ErrorType) {
            return $type;
        }
        return $type->toFloat();
    }
    public function isNumericString() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean(\is_numeric($this->getValue()));
    }
    public function hasOffsetValueType(\PHPStan\Type\Type $offsetType) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($offsetType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($offsetType->getValue() < \strlen($this->value));
        }
        return parent::hasOffsetValueType($offsetType);
    }
    public function getOffsetValueType(\PHPStan\Type\Type $offsetType) : \PHPStan\Type\Type
    {
        if ($offsetType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
            if ($offsetType->getValue() < \strlen($this->value)) {
                return new self($this->value[$offsetType->getValue()]);
            }
            return new \PHPStan\Type\ErrorType();
        }
        return parent::getOffsetValueType($offsetType);
    }
    public function setOffsetValueType(?\PHPStan\Type\Type $offsetType, \PHPStan\Type\Type $valueType) : \PHPStan\Type\Type
    {
        $valueStringType = $valueType->toString();
        if ($valueStringType instanceof \PHPStan\Type\ErrorType) {
            return new \PHPStan\Type\ErrorType();
        }
        if ($offsetType instanceof \PHPStan\Type\Constant\ConstantIntegerType && $valueStringType instanceof \PHPStan\Type\Constant\ConstantStringType) {
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
    public function generalize() : \PHPStan\Type\Type
    {
        if ($this->isClassString) {
            return new \PHPStan\Type\ClassStringType();
        }
        return new \PHPStan\Type\StringType();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['value'], $properties['isClassString'] ?? \false);
    }
}
