<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\TooWideTypehints;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Node\FunctionReturnStatementsNode;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Rule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\FunctionReturnStatementsNode>
 */
class TooWideFunctionReturnTypehintRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Node\FunctionReturnStatementsNode::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        $function = $scope->getFunction();
        if (!$function instanceof \_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        $functionReturnType = \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($function->getVariants())->getReturnType();
        if (!$functionReturnType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
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
        $returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$returnTypes);
        $messages = [];
        foreach ($functionReturnType->getTypes() as $type) {
            if (!$type->isSuperTypeOf($returnType)->no()) {
                continue;
            }
            $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Function %s() never returns %s so it can be removed from the return typehint.', $function->getName(), $type->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
