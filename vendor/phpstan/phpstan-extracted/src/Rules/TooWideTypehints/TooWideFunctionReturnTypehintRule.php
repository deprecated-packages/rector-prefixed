<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\TooWideTypehints;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\FunctionReturnStatementsNode;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\FunctionReturnStatementsNode>
 */
class TooWideFunctionReturnTypehintRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\FunctionReturnStatementsNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $function = $scope->getFunction();
        if (!$function instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $functionReturnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants())->getReturnType();
        if (!$functionReturnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return [];
        }
        $statementResult = $node->getStatementResult();
        if ($statementResult->hasYield()) {
            return [];
        }
        $returnStatements = $node->getReturnStatements();
        if (\count($returnStatements) === 0) {
            return [];
        }
        $returnTypes = [];
        foreach ($returnStatements as $returnStatement) {
            $returnNode = $returnStatement->getReturnNode();
            if ($returnNode->expr === null) {
                continue;
            }
            $returnTypes[] = $returnStatement->getScope()->getType($returnNode->expr);
        }
        if (\count($returnTypes) === 0) {
            return [];
        }
        $returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$returnTypes);
        $messages = [];
        foreach ($functionReturnType->getTypes() as $type) {
            if (!$type->isSuperTypeOf($returnType)->no()) {
                continue;
            }
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() never returns %s so it can be removed from the return typehint.', $function->getName(), $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
