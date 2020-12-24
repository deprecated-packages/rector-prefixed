<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Variables;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
/**
 * @implements \PHPStan\Rules\Rule<Node\Expr>
 */
class VariableCertaintyNullCoalesceRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Coalesce) {
            $var = $node->var;
            $description = '??=';
        } elseif ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Coalesce) {
            $var = $node->left;
            $description = '??';
        } else {
            return [];
        }
        $isSubNode = \false;
        while ($var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch || $var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch || $var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            if ($var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
                $var = $var->class;
            } else {
                $var = $var->var;
            }
            $isSubNode = \true;
        }
        if (!$var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable || !\is_string($var->name)) {
            return [];
        }
        $certainty = $scope->hasVariableType($var->name);
        if ($certainty->no()) {
            return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s is never defined.', $var->name, $description))->build()];
        } elseif ($certainty->yes() && !$isSubNode) {
            $variableType = $scope->getVariableType($var->name);
            if ($variableType->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\NullType())->no()) {
                return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s always exists and is not nullable.', $var->name, $description))->build()];
            } elseif ((new \_PhpScopere8e811afab72\PHPStan\Type\NullType())->isSuperTypeOf($variableType)->yes()) {
                return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s is always null.', $var->name, $description))->build()];
            }
        }
        return [];
    }
}
