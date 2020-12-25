<?php

declare (strict_types=1);
namespace PHPStan\Rules\DeadCode;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassConstantsNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ClassConstantsNode>
 */
class UnusedPrivateConstantRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PHPStan\Node\ClassConstantsNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->getClass() instanceof \PhpParser\Node\Stmt\Class_) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \PHPStan\ShouldNotHappenException();
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
            if (!$fetchNode->class instanceof \PhpParser\Node\Name) {
                continue;
            }
            if (!$fetchNode->name instanceof \PhpParser\Node\Identifier) {
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
            $errors[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Constant %s::%s is unused.', $classReflection->getDisplayName(), $constantName))->line($constantNode->getLine())->identifier('deadCode.unusedClassConstant')->metadata(['classOrder' => $node->getClass()->getAttribute('statementOrder'), 'classDepth' => $node->getClass()->getAttribute('statementDepth'), 'classStartLine' => $node->getClass()->getStartLine(), 'constantName' => $constantName])->build();
        }
        return $errors;
    }
}
