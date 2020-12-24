<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\DeadCode;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\ClassConstantsNode;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ClassConstantsNode>
 */
class UnusedPrivateConstantRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\ClassConstantsNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->getClass() instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $classReflection = $scope->getClassReflection();
        $constants = [];
        foreach ($node->getConstants() as $constant) {
            if (!$constant->isPrivate()) {
                continue;
            }
            foreach ($constant->consts as $const) {
                $constants[$const->name->toString()] = $const;
            }
        }
        foreach ($node->getFetches() as $fetch) {
            $fetchNode = $fetch->getNode();
            if (!$fetchNode->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                continue;
            }
            if (!$fetchNode->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
                continue;
            }
            $fetchScope = $fetch->getScope();
            $fetchedOnClass = $fetchScope->resolveName($fetchNode->class);
            if ($fetchedOnClass !== $classReflection->getName()) {
                continue;
            }
            unset($constants[$fetchNode->name->toString()]);
        }
        $errors = [];
        foreach ($constants as $constantName => $constantNode) {
            $errors[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Constant %s::%s is unused.', $classReflection->getDisplayName(), $constantName))->line($constantNode->getLine())->identifier('deadCode.unusedClassConstant')->metadata(['classOrder' => $node->getClass()->getAttribute('statementOrder'), 'classDepth' => $node->getClass()->getAttribute('statementDepth'), 'classStartLine' => $node->getClass()->getStartLine(), 'constantName' => $constantName])->build();
        }
        return $errors;
    }
}
