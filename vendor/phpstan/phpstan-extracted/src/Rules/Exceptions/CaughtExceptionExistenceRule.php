<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Exceptions;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Catch_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScopere8e811afab72\PHPStan\Rules\ClassNameNodePair;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Catch_>
 */
class CaughtExceptionExistenceRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var bool */
    private $checkClassCaseSensitivity;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, bool $checkClassCaseSensitivity)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->checkClassCaseSensitivity = $checkClassCaseSensitivity;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Catch_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        foreach ($node->types as $class) {
            $className = (string) $class;
            if (!$this->reflectionProvider->hasClass($className)) {
                if ($scope->isInClassExists($className)) {
                    continue;
                }
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Caught class %s not found.', $className))->line($class->getLine())->discoveringSymbolsTip()->build();
                continue;
            }
            $classReflection = $this->reflectionProvider->getClass($className);
            if (!$classReflection->isInterface() && !$classReflection->implementsInterface(\Throwable::class)) {
                $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Caught class %s is not an exception.', $classReflection->getDisplayName()))->line($class->getLine())->build();
            }
            if (!$this->checkClassCaseSensitivity) {
                continue;
            }
            $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScopere8e811afab72\PHPStan\Rules\ClassNameNodePair($className, $class)]));
        }
        return $errors;
    }
}
