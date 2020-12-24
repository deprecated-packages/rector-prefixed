<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Properties;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleError;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\StaticPropertyFetch>
 */
class AccessStaticPropertiesRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\VarLikeIdentifier) {
            $names = [$node->name->name];
        } else {
            $names = \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType $type) : string {
                return $type->getValue();
            }, \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($node->name)));
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
    private function processSingleProperty(\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch $node, string $name) : array
    {
        $messages = [];
        if ($node->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            $class = (string) $node->class;
            $lowercasedClass = \strtolower($class);
            if (\in_array($lowercasedClass, ['self', 'static'], \true)) {
                if (!$scope->isInClass()) {
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Accessing %s::$%s outside of class scope.', $class, $name))->build()];
                }
                $className = $scope->getClassReflection()->getName();
            } elseif ($lowercasedClass === 'parent') {
                if (!$scope->isInClass()) {
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Accessing %s::$%s outside of class scope.', $class, $name))->build()];
                }
                if ($scope->getClassReflection()->getParentClass() === \false) {
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s::%s() accesses parent::$%s but %s does not extend any class.', $scope->getClassReflection()->getDisplayName(), $scope->getFunctionName(), $name, $scope->getClassReflection()->getDisplayName()))->build()];
                }
                if ($scope->getFunctionName() === null) {
                    throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
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
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to static property $%s on an unknown class %s.', $name, $class))->discoveringSymbolsTip()->build()];
                } else {
                    $messages = $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair($class, $node->class)]);
                }
                $classReflection = $this->reflectionProvider->getClass($class);
                $className = $this->reflectionProvider->getClass($class)->getName();
                if ($classReflection->isTrait()) {
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to static property $%s on trait %s.', $name, $className))->build()];
                }
            }
            $classType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($className);
        } else {
            $classTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->class, \sprintf('Access to static property $%s on an unknown class %%s.', $name), static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($name) : bool {
                return $type->canAccessProperties()->yes() && $type->hasProperty($name)->yes();
            });
            $classType = $classTypeResult->getType();
            if ($classType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                return $classTypeResult->getUnknownClassErrors();
            }
        }
        if ((new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
            return [];
        }
        $typeForDescribe = $classType;
        $classType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::remove($classType, new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType());
        if ($scope->isInExpressionAssign($node)) {
            return [];
        }
        if (!$classType->canAccessProperties()->yes()) {
            return \array_merge($messages, [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access static property $%s on %s.', $name, $typeForDescribe->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->build()]);
        }
        if (!$classType->hasProperty($name)->yes()) {
            if ($scope->isSpecified($node)) {
                return $messages;
            }
            return \array_merge($messages, [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to an undefined static property %s::$%s.', $typeForDescribe->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()]);
        }
        $property = $classType->getProperty($name, $scope);
        if (!$property->isStatic()) {
            $hasPropertyTypes = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getHasPropertyTypes($classType);
            foreach ($hasPropertyTypes as $hasPropertyType) {
                if ($hasPropertyType->getPropertyName() === $name) {
                    return [];
                }
            }
            return \array_merge($messages, [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Static access to instance property %s::$%s.', $property->getDeclaringClass()->getDisplayName(), $name))->build()]);
        }
        if (!$scope->canAccessProperty($property)) {
            return \array_merge($messages, [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to %s property $%s of class %s.', $property->isPrivate() ? 'private' : 'protected', $name, $property->getDeclaringClass()->getDisplayName()))->build()]);
        }
        return $messages;
    }
}
