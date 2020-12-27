<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\TooWideTypehints;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Node\InArrowFunctionNode;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\NullType;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<InArrowFunctionNode>
 */
class TooWideArrowFunctionReturnTypehintRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \RectorPrefix20201227\PHPStan\Node\InArrowFunctionNode::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        $functionReturnType = $scope->getAnonymousFunctionReturnType();
        if ($functionReturnType === null || !$functionReturnType instanceof \PHPStan\Type\UnionType) {
            return [];
        }
        $arrowFunction = $node->getOriginalNode();
        if ($arrowFunction->returnType === null) {
            return [];
        }
        $expr = $arrowFunction->expr;
        if ($expr instanceof \PhpParser\Node\Expr\YieldFrom || $expr instanceof \PhpParser\Node\Expr\Yield_) {
            return [];
        }
        $returnType = $scope->getType($expr);
        if ($returnType instanceof \PHPStan\Type\NullType) {
            return [];
        }
        $messages = [];
        foreach ($functionReturnType->getTypes() as $type) {
            if (!$type->isSuperTypeOf($returnType)->no()) {
                continue;
            }
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Anonymous function never returns %s so it can be removed from the return typehint.', $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
