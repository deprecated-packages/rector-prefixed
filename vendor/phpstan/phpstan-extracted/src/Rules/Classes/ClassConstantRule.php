<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Classes;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ThisType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ClassConstFetch>
 */
class ClassConstantRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \_PhpScoperb75b35f52b74\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClassConstFetch::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
            return [];
        }
        $constantName = $node->name->name;
        $class = $node->class;
        $messages = [];
        if ($class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            $className = (string) $class;
            $lowercasedClassName = \strtolower($className);
            if (\in_array($lowercasedClassName, ['self', 'static'], \true)) {
                if (!$scope->isInClass()) {
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $className))->build()];
                }
                $className = $scope->getClassReflection()->getName();
            } elseif ($lowercasedClassName === 'parent') {
                if (!$scope->isInClass()) {
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $className))->build()];
                }
                $currentClassReflection = $scope->getClassReflection();
                if ($currentClassReflection->getParentClass() === \false) {
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to parent::%s but %s does not extend any class.', $constantName, $currentClassReflection->getDisplayName()))->build()];
                }
                $className = $currentClassReflection->getParentClass()->getName();
            } else {
                if (!$this->reflectionProvider->hasClass($className)) {
                    if ($scope->isInClassExists($className)) {
                        return [];
                    }
                    if (\strtolower($constantName) === 'class') {
                        return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s not found.', $className))->discoveringSymbolsTip()->build()];
                    }
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to constant %s on an unknown class %s.', $constantName, $className))->discoveringSymbolsTip()->build()];
                } else {
                    $messages = $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair($className, $class)]);
                }
                $className = $this->reflectionProvider->getClass($className)->getName();
            }
            if (\strtolower($constantName) === 'class') {
                return $messages;
            }
            if ($scope->isInClass() && $scope->getClassReflection()->getName() === $className) {
                $classType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType($scope->getClassReflection());
            } else {
                $classType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($className);
            }
        } else {
            $classTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $class, \sprintf('Access to constant %s on an unknown class %%s.', $constantName), static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) use($constantName) : bool {
                return $type->canAccessConstants()->yes() && $type->hasConstant($constantName)->yes();
            });
            $classType = $classTypeResult->getType();
            if ($classType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                return $classTypeResult->getUnknownClassErrors();
            }
            if (\strtolower($constantName) === 'class') {
                if (!$this->phpVersion->supportsClassConstantOnExpression()) {
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('Accessing ::class constant on an expression is supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
                }
                if ((new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
                    return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message('Accessing ::class constant on a dynamic string is not supported in PHP.')->nonIgnorable()->build()];
                }
            }
        }
        if ((new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
            return $messages;
        }
        $typeForDescribe = $classType;
        if ($classType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType) {
            $typeForDescribe = $classType->getStaticObjectType();
        }
        $classType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::remove($classType, new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType());
        if (!$classType->canAccessConstants()->yes()) {
            return \array_merge($messages, [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access constant %s on %s.', $constantName, $typeForDescribe->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->build()]);
        }
        if (\strtolower($constantName) === 'class') {
            return $messages;
        }
        if (!$classType->hasConstant($constantName)->yes()) {
            return \array_merge($messages, [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to undefined constant %s::%s.', $typeForDescribe->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly()), $constantName))->build()]);
        }
        $constantReflection = $classType->getConstant($constantName);
        if (!$scope->canAccessConstant($constantReflection)) {
            return \array_merge($messages, [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to %s constant %s of class %s.', $constantReflection->isPrivate() ? 'private' : 'protected', $constantName, $constantReflection->getDeclaringClass()->getDisplayName()))->build()]);
        }
        return $messages;
    }
}
