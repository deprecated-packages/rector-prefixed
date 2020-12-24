<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Methods;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<Node\Stmt\ClassMethod>
 */
class AbstractMethodInNonAbstractClassRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $class = $scope->getClassReflection();
        if ($class->isAbstract()) {
            return [];
        }
        if (!$node->isAbstract()) {
            return [];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Non-abstract class %s contains abstract method %s().', $class->getDisplayName(), $node->name->toString()))->nonIgnorable()->build()];
    }
}
