<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Classes;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Php\PhpVersion;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\ClassNameNodePair;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ThisType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\ClassConstFetch>
 */
class ClassConstantRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var PhpVersion */
    private $phpVersion;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \_PhpScoper0a2ac50786fa\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \_PhpScoper0a2ac50786fa\PHPStan\Php\PhpVersion $phpVersion)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->phpVersion = $phpVersion;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
            return [];
        }
        $constantName = $node->name->name;
        $class = $node->class;
        $messages = [];
        if ($class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
            $className = (string) $class;
            $lowercasedClassName = \strtolower($className);
            if (\in_array($lowercasedClassName, ['self', 'static'], \true)) {
                if (!$scope->isInClass()) {
                    return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $className))->build()];
                }
                $className = $scope->getClassReflection()->getName();
            } elseif ($lowercasedClassName === 'parent') {
                if (!$scope->isInClass()) {
                    return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $className))->build()];
                }
                $currentClassReflection = $scope->getClassReflection();
                if ($currentClassReflection->getParentClass() === \false) {
                    return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to parent::%s but %s does not extend any class.', $constantName, $currentClassReflection->getDisplayName()))->build()];
                }
                $className = $currentClassReflection->getParentClass()->getName();
            } else {
                if (!$this->reflectionProvider->hasClass($className)) {
                    if ($scope->isInClassExists($className)) {
                        return [];
                    }
                    if (\strtolower($constantName) === 'class') {
                        return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s not found.', $className))->discoveringSymbolsTip()->build()];
                    }
                    return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to constant %s on an unknown class %s.', $constantName, $className))->discoveringSymbolsTip()->build()];
                } else {
                    $messages = $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScoper0a2ac50786fa\PHPStan\Rules\ClassNameNodePair($className, $class)]);
                }
                $className = $this->reflectionProvider->getClass($className)->getName();
            }
            if (\strtolower($constantName) === 'class') {
                return $messages;
            }
            if ($scope->isInClass() && $scope->getClassReflection()->getName() === $className) {
                $classType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ThisType($scope->getClassReflection());
            } else {
                $classType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($className);
            }
        } else {
            $classTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $class, \sprintf('Access to constant %s on an unknown class %%s.', $constantName), static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) use($constantName) : bool {
                return $type->canAccessConstants()->yes() && $type->hasConstant($constantName)->yes();
            });
            $classType = $classTypeResult->getType();
            if ($classType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
                return $classTypeResult->getUnknownClassErrors();
            }
            if (\strtolower($constantName) === 'class') {
                if (!$this->phpVersion->supportsClassConstantOnExpression()) {
                    return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message('Accessing ::class constant on an expression is supported only on PHP 8.0 and later.')->nonIgnorable()->build()];
                }
                if ((new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
                    return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message('Accessing ::class constant on a dynamic string is not supported in PHP.')->nonIgnorable()->build()];
                }
            }
        }
        if ((new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
            return $messages;
        }
        $typeForDescribe = $classType;
        if ($classType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ThisType) {
            $typeForDescribe = $classType->getStaticObjectType();
        }
        $classType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::remove($classType, new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType());
        if (!$classType->canAccessConstants()->yes()) {
            return \array_merge($messages, [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot access constant %s on %s.', $constantName, $typeForDescribe->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly())))->build()]);
        }
        if (\strtolower($constantName) === 'class') {
            return $messages;
        }
        if (!$classType->hasConstant($constantName)->yes()) {
            return \array_merge($messages, [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to undefined constant %s::%s.', $typeForDescribe->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly()), $constantName))->build()]);
        }
        $constantReflection = $classType->getConstant($constantName);
        if (!$scope->canAccessConstant($constantReflection)) {
            return \array_merge($messages, [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Access to %s constant %s of class %s.', $constantReflection->isPrivate() ? 'private' : 'protected', $constantName, $constantReflection->getDeclaringClass()->getDisplayName()))->build()]);
        }
        return $messages;
    }
}
