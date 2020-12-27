<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\DeadCode;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\ClassConstantsNode;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ClassConstantsNode>
 */
class UnusedPrivateConstantRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\ClassConstantsNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->getClass() instanceof \PhpParser\Node\Stmt\Class_) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
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
            $errors[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Constant %s::%s is unused.', $classReflection->getDisplayName(), $constantName))->line($constantNode->getLine())->identifier('deadCode.unusedClassConstant')->metadata(['classOrder' => $node->getClass()->getAttribute('statementOrder'), 'classDepth' => $node->getClass()->getAttribute('statementDepth'), 'classStartLine' => $node->getClass()->getStartLine(), 'constantName' => $constantName])->build();
        }
        return $errors;
    }
}
