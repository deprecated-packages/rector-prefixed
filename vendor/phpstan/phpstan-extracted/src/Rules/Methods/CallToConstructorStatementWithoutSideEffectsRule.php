<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Methods;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class CallToConstructorStatementWithoutSideEffectsRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            return [];
        }
        $instantiation = $node->expr;
        if (!$instantiation->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return [];
        }
        $className = $scope->resolveName($instantiation->class);
        if (!$this->reflectionProvider->hasClass($className)) {
            return [];
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        if (!$classReflection->hasConstructor()) {
            return [];
        }
        $constructor = $classReflection->getConstructor();
        if ($constructor->hasSideEffects()->no()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to %s::%s() on a separate line has no effect.', $classReflection->getDisplayName(), $constructor->getName()))->build()];
        }
        return [];
    }
}
