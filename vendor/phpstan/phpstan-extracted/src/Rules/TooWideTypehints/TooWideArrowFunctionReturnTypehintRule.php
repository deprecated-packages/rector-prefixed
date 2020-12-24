<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\TooWideTypehints;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Node\InArrowFunctionNode;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<InArrowFunctionNode>
 */
class TooWideArrowFunctionReturnTypehintRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Node\InArrowFunctionNode::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        $functionReturnType = $scope->getAnonymousFunctionReturnType();
        if ($functionReturnType === null || !$functionReturnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return [];
        }
        $arrowFunction = $node->getOriginalNode();
        if ($arrowFunction->returnType === null) {
            return [];
        }
        $expr = $arrowFunction->expr;
        if ($expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\YieldFrom || $expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Yield_) {
            return [];
        }
        $returnType = $scope->getType($expr);
        if ($returnType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\NullType) {
            return [];
        }
        $messages = [];
        foreach ($functionReturnType->getTypes() as $type) {
            if (!$type->isSuperTypeOf($returnType)->no()) {
                continue;
            }
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Anonymous function never returns %s so it can be removed from the return typehint.', $type->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
