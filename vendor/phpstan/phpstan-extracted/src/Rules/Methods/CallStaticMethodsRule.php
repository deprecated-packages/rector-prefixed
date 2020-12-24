<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Methods;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeMethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpMethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoper0a6b37af0871\PHPStan\Rules\ClassNameNodePair;
use _PhpScoper0a6b37af0871\PHPStan\Rules\FunctionCallParametersCheck;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\StaticCall>
 */
class CallStaticMethodsRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\FunctionCallParametersCheck */
    private $check;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var bool */
    private $checkFunctionNameCase;
    /** @var bool */
    private $reportMagicMethods;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a6b37af0871\PHPStan\Rules\FunctionCallParametersCheck $check, \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, \_PhpScoper0a6b37af0871\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, bool $checkFunctionNameCase, bool $reportMagicMethods)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->check = $check;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->checkFunctionNameCase = $checkFunctionNameCase;
        $this->reportMagicMethods = $reportMagicMethods;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier) {
            return [];
        }
        $methodName = $node->name->name;
        $class = $node->class;
        $errors = [];
        $isAbstract = \false;
        if ($class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            $className = (string) $class;
            $lowercasedClassName = \strtolower($className);
            if (\in_array($lowercasedClassName, ['self', 'static'], \true)) {
                if (!$scope->isInClass()) {
                    return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Calling %s::%s() outside of class scope.', $className, $methodName))->build()];
                }
                $classReflection = $scope->getClassReflection();
            } elseif ($lowercasedClassName === 'parent') {
                if (!$scope->isInClass()) {
                    return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Calling %s::%s() outside of class scope.', $className, $methodName))->build()];
                }
                $currentClassReflection = $scope->getClassReflection();
                if ($currentClassReflection->getParentClass() === \false) {
                    return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s::%s() calls parent::%s() but %s does not extend any class.', $scope->getClassReflection()->getDisplayName(), $scope->getFunctionName(), $methodName, $scope->getClassReflection()->getDisplayName()))->build()];
                }
                if ($scope->getFunctionName() === null) {
                    throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
                }
                $classReflection = $currentClassReflection->getParentClass();
            } else {
                if (!$this->reflectionProvider->hasClass($className)) {
                    if ($scope->isInClassExists($className)) {
                        return [];
                    }
                    return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to static method %s() on an unknown class %s.', $methodName, $className))->discoveringSymbolsTip()->build()];
                } else {
                    $errors = $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScoper0a6b37af0871\PHPStan\Rules\ClassNameNodePair($className, $class)]);
                }
                $classReflection = $this->reflectionProvider->getClass($className);
            }
            $className = $classReflection->getName();
            $classType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($className);
            if ($classReflection->hasNativeMethod($methodName) && $lowercasedClassName !== 'static') {
                $nativeMethodReflection = $classReflection->getNativeMethod($methodName);
                if ($nativeMethodReflection instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\Php\PhpMethodReflection || $nativeMethodReflection instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeMethodReflection) {
                    $isAbstract = $nativeMethodReflection->isAbstract();
                }
            }
        } else {
            $classTypeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $class, \sprintf('Call to static method %s() on an unknown class %%s.', $methodName), static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) use($methodName) : bool {
                return $type->canCallMethods()->yes() && $type->hasMethod($methodName)->yes();
            });
            $classType = $classTypeResult->getType();
            if ($classType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
                return $classTypeResult->getUnknownClassErrors();
            }
        }
        if ($classType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType) {
            $classType = $classType->getGenericType();
        } elseif ((new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType())->isSuperTypeOf($classType)->yes()) {
            return [];
        }
        $typeForDescribe = $classType;
        $classType = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::remove($classType, new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType());
        if (!$classType->canCallMethods()->yes()) {
            return \array_merge($errors, [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot call static method %s() on %s.', $methodName, $typeForDescribe->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build()]);
        }
        if (!$classType->hasMethod($methodName)->yes()) {
            if (!$this->reportMagicMethods) {
                $directClassNames = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getDirectClassNames($classType);
                foreach ($directClassNames as $className) {
                    if (!$this->reflectionProvider->hasClass($className)) {
                        continue;
                    }
                    $classReflection = $this->reflectionProvider->getClass($className);
                    if ($classReflection->hasNativeMethod('__callStatic')) {
                        return [];
                    }
                }
            }
            return \array_merge($errors, [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to an undefined static method %s::%s().', $typeForDescribe->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly()), $methodName))->build()]);
        }
        $method = $classType->getMethod($methodName, $scope);
        if (!$method->isStatic()) {
            $function = $scope->getFunction();
            if (!$function instanceof \_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection || $function->isStatic() || !$scope->isInClass() || $classType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName && $scope->getClassReflection()->getName() !== $classType->getClassName() && !$scope->getClassReflection()->isSubclassOf($classType->getClassName())) {
                return \array_merge($errors, [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Static call to instance method %s::%s().', $method->getDeclaringClass()->getDisplayName(), $method->getName()))->build()]);
            }
        }
        if (!$scope->canCallMethod($method)) {
            $errors = \array_merge($errors, [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s %s %s() of class %s.', $method->isPrivate() ? 'private' : 'protected', $method->isStatic() ? 'static method' : 'method', $method->getName(), $method->getDeclaringClass()->getDisplayName()))->build()]);
        }
        if ($isAbstract) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot call abstract%s method %s::%s().', $method->isStatic() ? ' static' : '', $method->getDeclaringClass()->getDisplayName(), $method->getName()))->build()];
        }
        $lowercasedMethodName = \sprintf('%s %s', $method->isStatic() ? 'static method' : 'method', $method->getDeclaringClass()->getDisplayName() . '::' . $method->getName() . '()');
        $displayMethodName = \sprintf('%s %s', $method->isStatic() ? 'Static method' : 'Method', $method->getDeclaringClass()->getDisplayName() . '::' . $method->getName() . '()');
        $errors = \array_merge($errors, $this->check->check(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $method->getVariants()), $scope, $method->getDeclaringClass()->isBuiltin(), $node, [$displayMethodName . ' invoked with %d parameter, %d required.', $displayMethodName . ' invoked with %d parameters, %d required.', $displayMethodName . ' invoked with %d parameter, at least %d required.', $displayMethodName . ' invoked with %d parameters, at least %d required.', $displayMethodName . ' invoked with %d parameter, %d-%d required.', $displayMethodName . ' invoked with %d parameters, %d-%d required.', 'Parameter %s of ' . $lowercasedMethodName . ' expects %s, %s given.', 'Result of ' . $lowercasedMethodName . ' (void) is used.', 'Parameter %s of ' . $lowercasedMethodName . ' is passed by reference, so it expects variables only.', 'Unable to resolve the template type %s in call to method ' . $lowercasedMethodName, 'Missing parameter $%s in call to ' . $lowercasedMethodName . '.', 'Unknown parameter $%s in call to ' . $lowercasedMethodName . '.']));
        if ($this->checkFunctionNameCase && $method->getName() !== $methodName) {
            $errors[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s with incorrect case: %s', $lowercasedMethodName, $methodName))->build();
        }
        return $errors;
    }
}
