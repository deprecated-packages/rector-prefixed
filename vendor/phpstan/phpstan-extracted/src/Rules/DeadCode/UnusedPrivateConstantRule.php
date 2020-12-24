<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\DeadCode;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\ClassConstantsNode;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ClassConstantsNode>
 */
class UnusedPrivateConstantRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Node\ClassConstantsNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->getClass() instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
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
            if (!$fetchNode->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
                continue;
            }
            if (!$fetchNode->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
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
            $errors[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Constant %s::%s is unused.', $classReflection->getDisplayName(), $constantName))->line($constantNode->getLine())->identifier('deadCode.unusedClassConstant')->metadata(['classOrder' => $node->getClass()->getAttribute('statementOrder'), 'classDepth' => $node->getClass()->getAttribute('statementDepth'), 'classStartLine' => $node->getClass()->getStartLine(), 'constantName' => $constantName])->build();
        }
        return $errors;
    }
}
