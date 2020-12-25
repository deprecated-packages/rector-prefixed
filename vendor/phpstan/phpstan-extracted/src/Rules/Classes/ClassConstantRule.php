<?php

declare (strict_types=1);
namespace PHPStan\Rules\Classes;

use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PHPStan\Analyser\Scope;
use PHPStan\Php\PhpVersion;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\ClassCaseSensitivityCheck;
use PHPStan\Rules\ClassNameNodePair;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\ThisType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ClassConstFetch>
 */
class ClassConstantRule implements \PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\ClassConstFetch::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \PhpParser\Node\Identifier) {
            return [];
        }
        $constantName = $node->name->name;
        $class = $node->class;
        $messages = [];
        if ($class instanceof \PhpParser\Node\Name) {
            $className = (string) $class;
            $lowercasedClassName = \strtolower($className);
            if (\in_array($lowercasedClassName, ['self', 'static'], \true)) {
                if (!$scope->isInClass()) {
                    return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $className))->build()];
                }
                $className = $scope->getClassReflection()->getName();
            } elseif ($lowercasedClassName === 'parent') {
                if (!$scope->isInClass()) {
                    return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $className))->build()];
                }
                $currentClassReflection = $scope->getClassReflection();
                if ($currentClassReflection->getParentClass() === \false) {
                    return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to parent::%s but %s does not extend any class.', $constantName, $currentClassReflection->getDisplayName()))->build()];
                }
                $className = $currentClassReflection->getParentClass()->getName();
            } else {
                if (!$this->reflectionProvider->hasClass($className)) {
                    if ($scope->isInClassExists($className)) {
                        return [];
                    }
                    if (\strtolower($constantName) === 'class') {
                        return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s not found.', $className))->discoveringSymbolsTip()->build()];
                    }
                    return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to constant %s on an unknown class %s.', $constantName, $className))->discoveringSymbolsTip()->build()];
                } else {
                    $messages = $this->classCaseSensitivityCheck->checkClassNames([new \PHPStan\Rules\ClassNameNodePair($className, $class)]);
                }
                $className = $this->reflectionProvider->getClass($className)->getName();
            }
            if (\strtolower($constantName) === 'class') {
                return $messages;
            }
            if ($scope->isInClass() && $scope->getClassReflection()->getName() === $className) {
                $classType = new \PHPStan\Type\ThisType($scope->getClassReflection());
            } else {
                $classType = new \PHPStan\Type\ObjectType($className);
            }
        } else {
            $classTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $class, \sprintf('Access to constant %s on an unknown class %%s.', $constantName), static function (\PHPStan\Type\Type $type) use($constantName) : bool {
                return $type->canAccessConstants()->yes() && $type->hasConstant($constantName)->yes();
            });
            $classType = $classTypeResult->getType();
            if ($classType instanceof \PHPStan\Type\ErrorType) {
                return $classTypeResult->getUnknownClassErrors();
            }
            if (\strtolower($constantName) === 'class') {
                if (!$this->phpVersion->supportsClassConstantOnExpression()) {
                    return [\PHPStan\Rules\RuleErrorBuilder::message('Accessing ::class constant on an expression is supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
                }
                if ((new \PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
                    return [\PHPStan\Rules\RuleErrorBuilder::message('Accessing ::class constant on a dynamic string is not supported in PHP.')->nonIgnorable()->build()];
                }
            }
        }
        if ((new \PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
            return $messages;
        }
        $typeForDescribe = $classType;
        if ($classType instanceof \PHPStan\Type\ThisType) {
            $typeForDescribe = $classType->getStaticObjectType();
        }
        $classType = \PHPStan\Type\TypeCombinator::remove($classType, new \PHPStan\Type\StringType());
        if (!$classType->canAccessConstants()->yes()) {
            return \array_merge($messages, [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access constant %s on %s.', $constantName, $typeForDescribe->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()]);
        }
        if (\strtolower($constantName) === 'class') {
            return $messages;
        }
        if (!$classType->hasConstant($constantName)->yes()) {
            return \array_merge($messages, [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to undefined constant %s::%s.', $typeForDescribe->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $constantName))->build()]);
        }
        $constantReflection = $classType->getConstant($constantName);
        if (!$scope->canAccessConstant($constantReflection)) {
            return \array_merge($messages, [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to %s constant %s of class %s.', $constantReflection->isPrivate() ? 'private' : 'protected', $constantName, $constantReflection->getDeclaringClass()->getDisplayName()))->build()]);
        }
        return $messages;
    }
}
