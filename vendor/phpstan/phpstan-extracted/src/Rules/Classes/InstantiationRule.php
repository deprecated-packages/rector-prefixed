<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Classes;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair;
use _PhpScoperb75b35f52b74\PHPStan\Rules\FunctionCallParametersCheck;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleError;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\New_>
 */
class InstantiationRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\FunctionCallParametersCheck */
    private $check;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoperb75b35f52b74\PHPStan\Rules\FunctionCallParametersCheck $check, \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->check = $check;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        foreach ($this->getClassNames($node, $scope) as $class) {
            $errors = \array_merge($errors, $this->checkClassName($class, $node, $scope));
        }
        return $errors;
    }
    /**
     * @param string $class
     * @param \PhpParser\Node\Expr\New_ $node
     * @param Scope $scope
     * @return RuleError[]
     */
    private function checkClassName(string $class, \_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $lowercasedClass = \strtolower($class);
        $messages = [];
        $isStatic = \false;
        if ($lowercasedClass === 'static') {
            if (!$scope->isInClass()) {
                return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $class))->build()];
            }
            $isStatic = \true;
            $classReflection = $scope->getClassReflection();
            if (!$classReflection->isFinal()) {
                if (!$classReflection->hasConstructor()) {
                    return [];
                }
                $constructor = $classReflection->getConstructor();
                if (!$constructor->getPrototype()->getDeclaringClass()->isInterface() && $constructor instanceof \_PhpScoperb75b35f52b74\PHPStan\Reflection\Php\PhpMethodReflection && !$constructor->isFinal()->yes() && !$constructor->getPrototype()->isAbstract()) {
                    return [];
                }
            }
        } elseif ($lowercasedClass === 'self') {
            if (!$scope->isInClass()) {
                return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $class))->build()];
            }
            $classReflection = $scope->getClassReflection();
        } elseif ($lowercasedClass === 'parent') {
            if (!$scope->isInClass()) {
                return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Using %s outside of class scope.', $class))->build()];
            }
            if ($scope->getClassReflection()->getParentClass() === \false) {
                return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s::%s() calls new parent but %s does not extend any class.', $scope->getClassReflection()->getDisplayName(), $scope->getFunctionName(), $scope->getClassReflection()->getDisplayName()))->build()];
            }
            $classReflection = $scope->getClassReflection()->getParentClass();
        } else {
            if (!$this->reflectionProvider->hasClass($class)) {
                if ($scope->isInClassExists($class)) {
                    return [];
                }
                return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instantiated class %s not found.', $class))->discoveringSymbolsTip()->build()];
            } else {
                $messages = $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScoperb75b35f52b74\PHPStan\Rules\ClassNameNodePair($class, $node->class)]);
            }
            $classReflection = $this->reflectionProvider->getClass($class);
        }
        if (!$isStatic && $classReflection->isInterface()) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot instantiate interface %s.', $classReflection->getDisplayName()))->build()];
        }
        if (!$isStatic && $classReflection->isAbstract()) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Instantiated class %s is abstract.', $classReflection->getDisplayName()))->build()];
        }
        if (!$classReflection->hasConstructor()) {
            if (\count($node->args) > 0) {
                return \array_merge($messages, [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Class %s does not have a constructor and must be instantiated without any parameters.', $classReflection->getDisplayName()))->build()]);
            }
            return $messages;
        }
        $constructorReflection = $classReflection->getConstructor();
        if (!$scope->canCallMethod($constructorReflection)) {
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot instantiate class %s via %s constructor %s::%s().', $classReflection->getDisplayName(), $constructorReflection->isPrivate() ? 'private' : 'protected', $constructorReflection->getDeclaringClass()->getDisplayName(), $constructorReflection->getName()))->build();
        }
        return \array_merge($messages, $this->check->check(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $node->args, $constructorReflection->getVariants()), $scope, $constructorReflection->getDeclaringClass()->isBuiltin(), $node, [
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameter, %d required.',
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameters, %d required.',
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameter, at least %d required.',
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameters, at least %d required.',
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameter, %d-%d required.',
            'Class ' . $classReflection->getDisplayName() . ' constructor invoked with %d parameters, %d-%d required.',
            'Parameter %s of class ' . $classReflection->getDisplayName() . ' constructor expects %s, %s given.',
            '',
            // constructor does not have a return type
            'Parameter %s of class ' . $classReflection->getDisplayName() . ' constructor is passed by reference, so it expects variables only',
            'Unable to resolve the template type %s in instantiation of class ' . $classReflection->getDisplayName(),
            'Missing parameter $%s in call to ' . $classReflection->getDisplayName() . ' constructor.',
            'Unknown parameter $%s in call to ' . $classReflection->getDisplayName() . ' constructor.',
        ]));
    }
    /**
     * @param \PhpParser\Node\Expr\New_ $node $node
     * @param Scope $scope
     * @return string[]
     */
    private function getClassNames(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
            return [(string) $node->class];
        }
        if ($node->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            $anonymousClassType = $scope->getType($node);
            if (!$anonymousClassType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            }
            return [$anonymousClassType->getClassName()];
        }
        $type = $scope->getType($node->class);
        return \array_merge(\array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType $type) : string {
            return $type->getValue();
        }, \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantStrings($type)), \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getDirectClassNames($type));
    }
}
