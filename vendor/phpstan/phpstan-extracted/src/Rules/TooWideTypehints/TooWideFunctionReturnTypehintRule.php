<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\TooWideTypehints;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\FunctionReturnStatementsNode;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\FunctionReturnStatementsNode>
 */
class TooWideFunctionReturnTypehintRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\FunctionReturnStatementsNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $function = $scope->getFunction();
        if (!$function instanceof \RectorPrefix20201227\PHPStan\Reflection\FunctionReflection) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $functionReturnType = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants())->getReturnType();
        if (!$functionReturnType instanceof \PHPStan\Type\UnionType) {
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
        $messages = [];
        foreach ($functionReturnType->getTypes() as $type) {
            if (!$type->isSuperTypeOf($returnType)->no()) {
                continue;
            }
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() never returns %s so it can be removed from the return typehint.', $function->getName(), $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
