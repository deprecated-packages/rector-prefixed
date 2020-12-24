<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Exceptions;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Catch_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassCaseSensitivityCheck;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassNameNodePair;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Catch_>
 */
class CaughtExceptionExistenceRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var bool */
    private $checkClassCaseSensitivity;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, bool $checkClassCaseSensitivity)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->checkClassCaseSensitivity = $checkClassCaseSensitivity;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Catch_::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        $errors = [];
        foreach ($node->types as $class) {
            $className = (string) $class;
            if (!$this->reflectionProvider->hasClass($className)) {
                if ($scope->isInClassExists($className)) {
                    continue;
                }
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Caught class %s not found.', $className))->line($class->getLine())->discoveringSymbolsTip()->build();
                continue;
            }
            $classReflection = $this->reflectionProvider->getClass($className);
            if (!$classReflection->isInterface() && !$classReflection->implementsInterface(\Throwable::class)) {
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Caught class %s is not an exception.', $classReflection->getDisplayName()))->line($class->getLine())->build();
            }
            if (!$this->checkClassCaseSensitivity) {
                continue;
            }
            $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassNameNodePair($className, $class)]));
        }
        return $errors;
    }
}
