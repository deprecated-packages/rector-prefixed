<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Methods;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\FunctionCallParametersCheck;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\MethodCall>
 */
class CallMethodsRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\FunctionCallParametersCheck */
    private $check;
    /** @var \PHPStan\Rules\RuleLevelHelper */
    private $ruleLevelHelper;
    /** @var bool */
    private $checkFunctionNameCase;
    /** @var bool */
    private $reportMagicMethods;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \RectorPrefix20201227\PHPStan\Rules\FunctionCallParametersCheck $check, \RectorPrefix20201227\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $checkFunctionNameCase, bool $reportMagicMethods)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->check = $check;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->checkFunctionNameCase = $checkFunctionNameCase;
        $this->reportMagicMethods = $reportMagicMethods;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\MethodCall::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \PhpParser\Node\Identifier) {
            return [];
        }
        $name = $node->name->name;
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, \sprintf('Call to method %s() on an unknown class %%s.', $name), static function (\PHPStan\Type\Type $type) use($name) : bool {
            return $type->canCallMethods()->yes() && $type->hasMethod($name)->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        if (!$type->canCallMethods()->yes()) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot call method %s() on %s.', $name, $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
        }
        if (!$type->hasMethod($name)->yes()) {
            $directClassNames = $typeResult->getReferencedClasses();
            if (!$this->reportMagicMethods) {
                foreach ($directClassNames as $className) {
                    if (!$this->reflectionProvider->hasClass($className)) {
                        continue;
                    }
                    $classReflection = $this->reflectionProvider->getClass($className);
                    if ($classReflection->hasNativeMethod('__call')) {
                        return [];
                    }
                }
            }
            if (\count($directClassNames) === 1) {
                $referencedClass = $directClassNames[0];
                $methodClassReflection = $this->reflectionProvider->getClass($referencedClass);
                $parentClassReflection = $methodClassReflection->getParentClass();
                while ($parentClassReflection !== \false) {
                    if ($parentClassReflection->hasMethod($name)) {
                        return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to private method %s() of parent class %s.', $parentClassReflection->getMethod($name, $scope)->getName(), $parentClassReflection->getDisplayName()))->build()];
                    }
                    $parentClassReflection = $parentClassReflection->getParentClass();
                }
            }
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to an undefined method %s::%s().', $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()];
        }
        $methodReflection = $type->getMethod($name, $scope);
        $declaringClass = $methodReflection->getDeclaringClass();
        $messagesMethodName = $declaringClass->getDisplayName() . '::' . $methodReflection->getName() . '()';
        $errors = [];
        if (!$scope->canCallMethod($methodReflection)) {
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s method %s() of class %s.', $methodReflection->isPrivate() ? 'private' : 'protected', $methodReflection->getName(), $declaringClass->getDisplayName()))->build();
        }
        $errors = \array_merge($errors, $this->check->check(\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $methodReflection->getVariants()), $scope, $declaringClass->isBuiltin(), $node, ['Method ' . $messagesMethodName . ' invoked with %d parameter, %d required.', 'Method ' . $messagesMethodName . ' invoked with %d parameters, %d required.', 'Method ' . $messagesMethodName . ' invoked with %d parameter, at least %d required.', 'Method ' . $messagesMethodName . ' invoked with %d parameters, at least %d required.', 'Method ' . $messagesMethodName . ' invoked with %d parameter, %d-%d required.', 'Method ' . $messagesMethodName . ' invoked with %d parameters, %d-%d required.', 'Parameter %s of method ' . $messagesMethodName . ' expects %s, %s given.', 'Result of method ' . $messagesMethodName . ' (void) is used.', 'Parameter %s of method ' . $messagesMethodName . ' is passed by reference, so it expects variables only.', 'Unable to resolve the template type %s in call to method ' . $messagesMethodName, 'Missing parameter $%s in call to method ' . $messagesMethodName . '.', 'Unknown parameter $%s in call to method ' . $messagesMethodName . '.']));
        if ($this->checkFunctionNameCase && \strtolower($methodReflection->getName()) === \strtolower($name) && $methodReflection->getName() !== $name) {
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to method %s with incorrect case: %s', $messagesMethodName, $name))->build();
        }
        return $errors;
    }
}
