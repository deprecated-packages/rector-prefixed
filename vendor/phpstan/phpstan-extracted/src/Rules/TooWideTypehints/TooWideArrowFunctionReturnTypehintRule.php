<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\TooWideTypehints;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Node\InArrowFunctionNode;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements Rule<InArrowFunctionNode>
 */
class TooWideArrowFunctionReturnTypehintRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PHPStan\Node\InArrowFunctionNode::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $functionReturnType = $scope->getAnonymousFunctionReturnType();
        if ($functionReturnType === null || !$functionReturnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
            return [];
        }
        $arrowFunction = $node->getOriginalNode();
        if ($arrowFunction->returnType === null) {
            return [];
        }
        $expr = $arrowFunction->expr;
        if ($expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\YieldFrom || $expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Yield_) {
            return [];
        }
        $returnType = $scope->getType($expr);
        if ($returnType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NullType) {
            return [];
        }
        $messages = [];
        foreach ($functionReturnType->getTypes() as $type) {
            if (!$type->isSuperTypeOf($returnType)->no()) {
                continue;
            }
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Anonymous function never returns %s so it can be removed from the return typehint.', $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::typeOnly())))->build();
        }
        return $messages;
    }
}
