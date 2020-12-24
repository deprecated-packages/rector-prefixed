<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Methods;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Rules\FunctionCallParametersCheck;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper;
use _PhpScoper0a6b37af0871\PHPStan\Type\ErrorType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\MethodCall>
 */
class CallMethodsRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
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
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a6b37af0871\PHPStan\Rules\FunctionCallParametersCheck $check, \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleLevelHelper $ruleLevelHelper, bool $checkFunctionNameCase, bool $reportMagicMethods)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->check = $check;
        $this->ruleLevelHelper = $ruleLevelHelper;
        $this->checkFunctionNameCase = $checkFunctionNameCase;
        $this->reportMagicMethods = $reportMagicMethods;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->name instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier) {
            return [];
        }
        $name = $node->name->name;
        $typeResult = $this->ruleLevelHelper->findTypeToCheck($scope, $node->var, \sprintf('Call to method %s() on an unknown class %%s.', $name), static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) use($name) : bool {
            return $type->canCallMethods()->yes() && $type->hasMethod($name)->yes();
        });
        $type = $typeResult->getType();
        if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ErrorType) {
            return $typeResult->getUnknownClassErrors();
        }
        if (!$type->canCallMethods()->yes()) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot call method %s() on %s.', $name, $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build()];
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
                        return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to private method %s() of parent class %s.', $parentClassReflection->getMethod($name, $scope)->getName(), $parentClassReflection->getDisplayName()))->build()];
                    }
                    $parentClassReflection = $parentClassReflection->getParentClass();
                }
            }
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to an undefined method %s::%s().', $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly()), $name))->build()];
        }
        $methodReflection = $type->getMethod($name, $scope);
        $declaringClass = $methodReflection->getDeclaringClass();
        $messagesMethodName = $declaringClass->getDisplayName() . '::' . $methodReflection->getName() . '()';
        $errors = [];
        if (!$scope->canCallMethod($methodReflection)) {
            $errors[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s method %s() of class %s.', $methodReflection->isPrivate() ? 'private' : 'protected', $methodReflection->getName(), $declaringClass->getDisplayName()))->build();
        }
        $errors = \array_merge($errors, $this->check->check(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $methodReflection->getVariants()), $scope, $declaringClass->isBuiltin(), $node, ['Method ' . $messagesMethodName . ' invoked with %d parameter, %d required.', 'Method ' . $messagesMethodName . ' invoked with %d parameters, %d required.', 'Method ' . $messagesMethodName . ' invoked with %d parameter, at least %d required.', 'Method ' . $messagesMethodName . ' invoked with %d parameters, at least %d required.', 'Method ' . $messagesMethodName . ' invoked with %d parameter, %d-%d required.', 'Method ' . $messagesMethodName . ' invoked with %d parameters, %d-%d required.', 'Parameter %s of method ' . $messagesMethodName . ' expects %s, %s given.', 'Result of method ' . $messagesMethodName . ' (void) is used.', 'Parameter %s of method ' . $messagesMethodName . ' is passed by reference, so it expects variables only.', 'Unable to resolve the template type %s in call to method ' . $messagesMethodName, 'Missing parameter $%s in call to method ' . $messagesMethodName . '.', 'Unknown parameter $%s in call to method ' . $messagesMethodName . '.']));
        if ($this->checkFunctionNameCase && \strtolower($methodReflection->getName()) === \strtolower($name) && $methodReflection->getName() !== $name) {
            $errors[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to method %s with incorrect case: %s', $messagesMethodName, $name))->build();
        }
        return $errors;
    }
}
