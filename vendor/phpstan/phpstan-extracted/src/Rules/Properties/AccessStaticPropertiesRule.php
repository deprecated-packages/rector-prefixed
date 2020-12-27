<?php

declare (strict_types=1);
namespace PHPStan\Rules\Properties;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\ClassNameNodePair;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\StaticPropertyFetch>
 */
class AccessStaticPropertiesRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\StaticPropertyFetch::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->name instanceof \PhpParser\Node\VarLikeIdentifier) {
            $names = [$node->name->name];
        } else {
            $names = \array_map(static function (\PHPStan\Type\Constant\ConstantStringType $type) : string {
                return $type->getValue();
            }, \PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($node->name)));
        }
        $errors = [];
        foreach ($names as $name) {
            $errors = \array_merge($errors, $this->processSingleProperty($scope, $node, $name));
        }
        return $errors;
    }
    /**
     * @param Scope $scope
     * @param StaticPropertyFetch $node
     * @param string $name
     * @return RuleError[]
     */
    private function processSingleProperty(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr\StaticPropertyFetch $node, string $name) : array
    {
        $messages = [];
        if ($node->class instanceof \PhpParser\Node\Name) {
            $class = (string) $node->class;
            $lowercasedClass = \strtolower($class);
            if (\in_array($lowercasedClass, ['self', 'static'], \true)) {
                if (!$scope->isInClass()) {
                    return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Accessing %s::$%s outside of class scope.', $class, $name))->build()];
                }
                $className = $scope->getClassReflection()->getName();
            } elseif ($lowercasedClass === 'parent') {
                if (!$scope->isInClass()) {
                    return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Accessing %s::$%s outside of class scope.', $class, $name))->build()];
                }
                if ($scope->getClassReflection()->getParentClass() === \false) {
                    return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s::%s() accesses parent::$%s but %s does not extend any class.', $scope->getClassReflection()->getDisplayName(), $scope->getFunctionName(), $name, $scope->getClassReflection()->getDisplayName()))->build()];
                }
                if ($scope->getFunctionName() === null) {
                    throw new \PHPStan\ShouldNotHappenException();
                }
                $currentMethodReflection = $scope->getClassReflection()->getNativeMethod($scope->getFunctionName());
                if (!$currentMethodReflection->isStatic()) {
                    // calling parent::method() from instance method
                    return [];
                }
                $className = $scope->getClassReflection()->getParentClass()->getName();
            } else {
                if (!$this->reflectionProvider->hasClass($class)) {
                    if ($scope->isInClassExists($class)) {
                        return [];
                    }
                    return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to static property $%s on an unknown class %s.', $name, $class))->discoveringSymbolsTip()->build()];
                } else {
                    $messages = $this->classCaseSensitivityCheck->checkClassNames([new \PHPStan\Rules\ClassNameNodePair($class, $node->class)]);
                }
                $classReflection = $this->reflectionProvider->getClass($class);
                $className = $this->reflectionProvider->getClass($class)->getName();
                if ($classReflection->isTrait()) {
                    return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to static property $%s on trait %s.', $name, $className))->build()];
                }
            }
            $classType = new \PHPStan\Type\ObjectType($className);
        } else {
            $classTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->class, \sprintf('Access to static property $%s on an unknown class %%s.', $name), static function (\PHPStan\Type\Type $type) use($name) : bool {
                return $type->canAccessProperties()->yes() && $type->hasProperty($name)->yes();
            });
            $classType = $classTypeResult->getType();
            if ($classType instanceof \PHPStan\Type\ErrorType) {
                return $classTypeResult->getUnknownClassErrors();
            }
        }
        if ((new \PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
            return [];
        }
        $typeForDescribe = $classType;
        $classType = \PHPStan\Type\TypeCombinator::remove($classType, new \PHPStan\Type\StringType());
        if ($scope->isInExpressionAssign($node)) {
            return [];
        }
        if (!$classType->canAccessProperties()->yes()) {
            return \array_merge($messages, [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access static property $%s on %s.', $name, $typeForDescribe->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()]);
        }
        if (!$classType->hasProperty($name)->yes()) {
            if ($scope->isSpecified($node)) {
                return $messages;
            }
            return \array_merge($messages, [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to an undefined static property %s::$%s.', $typeForDescribe->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()]);
        }
        $property = $classType->getProperty($name, $scope);
        if (!$property->isStatic()) {
            $hasPropertyTypes = \PHPStan\Type\TypeUtils::getHasPropertyTypes($classType);
            foreach ($hasPropertyTypes as $hasPropertyType) {
                if ($hasPropertyType->getPropertyName() === $name) {
                    return [];
                }
            }
            return \array_merge($messages, [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Static access to instance property %s::$%s.', $property->getDeclaringClass()->getDisplayName(), $name))->build()]);
        }
        if (!$scope->canAccessProperty($property)) {
            return \array_merge($messages, [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to %s property $%s of class %s.', $property->isPrivate() ? 'private' : 'protected', $name, $property->getDeclaringClass()->getDisplayName()))->build()]);
        }
        return $messages;
    }
}
