<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Constant;

use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\Broker\Broker;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\InaccessibleMethod;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\TrivialParametersAcceptor;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\CompoundType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Traits\ConstantScalarTypeTrait;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
class ConstantStringType extends \_PhpScoperb75b35f52b74\PHPStan\Type\StringType implements \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantScalarType
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
    public function describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel $level) : string
    {
        return $level->handle(static function () : string {
            return 'string';
        }, function () : string {
            if ($this->isClassString) {
                return \var_export($this->value, \true);
            }
            try {
                $truncatedValue = \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::truncate($this->value, self::DESCRIBE_LIMIT);
            } catch (\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\RegexpException $e) {
                $truncatedValue = \substr($this->value, 0, self::DESCRIBE_LIMIT) . "…";
            }
            return \var_export($truncatedValue, \true);
        }, function () : string {
            return \var_export($this->value, \true);
        });
    }
    public function isSuperTypeOf(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType) {
            $genericType = $type->getGenericType();
            if ($genericType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
            }
            if ($genericType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType) {
                $genericType = $genericType->getStaticObjectType();
            }
            // We are transforming constant class-string to ObjectType. But we need to filter out
            // an uncertainty originating in possible ObjectType's class subtypes.
            $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($this->getValue());
            // Do not use TemplateType's isSuperTypeOf handling directly because it takes ObjectType
            // uncertainty into account.
            if ($genericType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType) {
                $isSuperType = $genericType->getBound()->isSuperTypeOf($objectType);
            } else {
                $isSuperType = $genericType->isSuperTypeOf($objectType);
            }
            // Explicitly handle the uncertainty for Yes & Maybe.
            if ($isSuperType->yes()) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType) {
            $broker = \_PhpScoperb75b35f52b74\PHPStan\Broker\Broker::getInstance();
            return $broker->hasClass($this->getValue()) ? \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof self) {
            return $this->value === $type->value ? \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        }
        if ($type instanceof parent) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    public function isCallable() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($this->value === '') {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        }
        $broker = \_PhpScoperb75b35f52b74\PHPStan\Broker\Broker::getInstance();
        // 'my_function'
        if ($broker->hasFunction(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($this->value), null)) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
        }
        // 'MyClass::myStaticFunction'
        $matches = \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($this->value, '#^([a-zA-Z_\\x7f-\\xff\\\\][a-zA-Z0-9_\\x7f-\\xff\\\\]*)::([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)\\z#');
        if ($matches !== null) {
            if (!$broker->hasClass($matches[1])) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
            }
            $classRef = $broker->getClass($matches[1]);
            if ($classRef->hasMethod($matches[2])) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createYes();
            }
            if (!$classRef->getNativeReflection()->isFinal()) {
                return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createMaybe();
            }
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createNo();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        $broker = \_PhpScoperb75b35f52b74\PHPStan\Broker\Broker::getInstance();
        // 'my_function'
        $functionName = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($this->value);
        if ($broker->hasFunction($functionName, null)) {
            return $broker->getFunction($functionName, null)->getVariants();
        }
        // 'MyClass::myStaticFunction'
        $matches = \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\Utils\Strings::match($this->value, '#^([a-zA-Z_\\x7f-\\xff\\\\][a-zA-Z0-9_\\x7f-\\xff\\\\]*)::([a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*)\\z#');
        if ($matches !== null) {
            if (!$broker->hasClass($matches[1])) {
                return [new \_PhpScoperb75b35f52b74\PHPStan\Reflection\TrivialParametersAcceptor()];
            }
            $classReflection = $broker->getClass($matches[1]);
            if ($classReflection->hasMethod($matches[2])) {
                $method = $classReflection->getMethod($matches[2], $scope);
                if (!$scope->canCallMethod($method)) {
                    return [new \_PhpScoperb75b35f52b74\PHPStan\Reflection\InaccessibleMethod($method)];
                }
                return $method->getVariants();
            }
            if (!$classReflection->getNativeReflection()->isFinal()) {
                return [new \_PhpScoperb75b35f52b74\PHPStan\Reflection\TrivialParametersAcceptor()];
            }
        }
        throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
    }
    public function toNumber() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (\is_numeric($this->value)) {
            /** @var mixed $value */
            $value = $this->value;
            $value = +$value;
            if (\is_float($value)) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType($value);
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType($value);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
    }
    public function toInteger() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->toNumber();
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return $type;
        }
        return $type->toInteger();
    }
    public function toFloat() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $type = $this->toNumber();
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return $type;
        }
        return $type->toFloat();
    }
    public function isNumericString() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean(\is_numeric($this->getValue()));
    }
    public function hasOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        if ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType) {
            return \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic::createFromBoolean($offsetType->getValue() < \strlen($this->value));
        }
        return parent::hasOffsetValueType($offsetType);
    }
    public function getOffsetValueType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType) {
            if ($offsetType->getValue() < \strlen($this->value)) {
                return new self($this->value[$offsetType->getValue()]);
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        }
        return parent::getOffsetValueType($offsetType);
    }
    public function setOffsetValueType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $offsetType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $valueType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $valueStringType = $valueType->toString();
        if ($valueStringType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType();
        }
        if ($offsetType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType && $valueStringType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
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
    public function generalize() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($this->isClassString) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType();
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return new self($properties['value'], $properties['isClassString'] ?? \false);
    }
}
