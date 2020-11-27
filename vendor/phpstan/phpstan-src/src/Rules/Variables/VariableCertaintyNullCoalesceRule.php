<?php

declare (strict_types=1);
namespace PHPStan\Rules\Variables;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\NullType;
/**
 * @implements \PHPStan\Rules\Rule<Node\Expr>
 */
class VariableCertaintyNullCoalesceRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \PhpParser\Node\Expr\AssignOp\Coalesce) {
            $var = $node->var;
            $description = '??=';
        } elseif ($node instanceof \PhpParser\Node\Expr\BinaryOp\Coalesce) {
            $var = $node->left;
            $description = '??';
        } else {
            return [];
        }
        $isSubNode = \false;
        while ($var instanceof \PhpParser\Node\Expr\ArrayDimFetch || $var instanceof \PhpParser\Node\Expr\PropertyFetch || $var instanceof \PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \PhpParser\Node\Expr) {
            if ($var instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
                $var = $var->class;
            } else {
                $var = $var->var;
            }
            $isSubNode = \true;
        }
        if (!$var instanceof \PhpParser\Node\Expr\Variable || !\is_string($var->name)) {
            return [];
        }
        $certainty = $scope->hasVariableType($var->name);
        if ($certainty->no()) {
            return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s is never defined.', $var->name, $description))->build()];
        } elseif ($certainty->yes() && !$isSubNode) {
            $variableType = $scope->getVariableType($var->name);
            if ($variableType->isSuperTypeOf(new \PHPStan\Type\NullType())->no()) {
                return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s always exists and is not nullable.', $var->name, $description))->build()];
            } elseif ((new \PHPStan\Type\NullType())->isSuperTypeOf($variableType)->yes()) {
                return [\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s is always null.', $var->name, $description))->build()];
            }
        }
        return [];
    }
}
