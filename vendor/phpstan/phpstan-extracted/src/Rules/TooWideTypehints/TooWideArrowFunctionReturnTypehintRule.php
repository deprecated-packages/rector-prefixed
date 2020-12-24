<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\TooWideTypehints;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\InArrowFunctionNode;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<InArrowFunctionNode>
 */
class TooWideArrowFunctionReturnTypehintRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\InArrowFunctionNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $functionReturnType = $scope->getAnonymousFunctionReturnType();
        if ($functionReturnType === null || !$functionReturnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            return [];
        }
        $arrowFunction = $node->getOriginalNode();
        if ($arrowFunction->returnType === null) {
            return [];
        }
        $expr = $arrowFunction->expr;
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\YieldFrom || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Yield_) {
            return [];
        }
        $returnType = $scope->getType($expr);
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\NullType) {
            return [];
        }
        $messages = [];
        foreach ($functionReturnType->getTypes() as $type) {
            if (!$type->isSuperTypeOf($returnType)->no()) {
                continue;
            }
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Anonymous function never returns %s so it can be removed from the return typehint.', $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
