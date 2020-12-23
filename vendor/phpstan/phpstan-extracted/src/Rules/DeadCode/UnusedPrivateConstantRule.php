<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\DeadCode;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\ClassConstantsNode;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Rule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements Rule<ClassConstantsNode>
 */
class UnusedPrivateConstantRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Node\ClassConstantsNode::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node->getClass() instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return [];
        }
        if (!$scope->isInClass()) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
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
            if (!$fetchNode->class instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
                continue;
            }
            if (!$fetchNode->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
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
            $errors[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Constant %s::%s is unused.', $classReflection->getDisplayName(), $constantName))->line($constantNode->getLine())->identifier('deadCode.unusedClassConstant')->metadata(['classOrder' => $node->getClass()->getAttribute('statementOrder'), 'classDepth' => $node->getClass()->getAttribute('statementDepth'), 'classStartLine' => $node->getClass()->getStartLine(), 'constantName' => $constantName])->build();
        }
        return $errors;
    }
}
