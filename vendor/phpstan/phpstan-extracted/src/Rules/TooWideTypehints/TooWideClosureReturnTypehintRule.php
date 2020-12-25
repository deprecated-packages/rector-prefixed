<?php

declare (strict_types=1);
namespace PHPStan\Rules\TooWideTypehints;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClosureReturnStatementsNode;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\NullType;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\ClosureReturnStatementsNode>
 */
class TooWideClosureReturnTypehintRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PHPStan\Node\ClosureReturnStatementsNode::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $closureReturnType = $scope->getAnonymousFunctionReturnType();
        if ($closureReturnType === null || !$closureReturnType instanceof \PHPStan\Type\UnionType) {
            return [];
        }
        $closureExpr = $node->getClosureExpr();
        if ($closureExpr->returnType === null) {
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
        $returnType = \PHPStan\Type\TypeCombinator::union(...$returnTypes);
        if ($returnType instanceof \PHPStan\Type\NullType) {
            return [];
        }
        $messages = [];
        foreach ($closureReturnType->getTypes() as $type) {
            if (!$type->isSuperTypeOf($returnType)->no()) {
                continue;
            }
            $messages[] = \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Anonymous function never returns %s so it can be removed from the return typehint.', $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
