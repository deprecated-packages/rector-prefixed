<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Variables;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
/**
 * @implements \PHPStan\Rules\Rule<Node\Expr>
 */
class VariableCertaintyNullCoalesceRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\AssignOp\Coalesce) {
            $var = $node->var;
            $description = '??=';
        } elseif ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce) {
            $var = $node->left;
            $description = '??';
        } else {
            return [];
        }
        $isSubNode = \false;
        while ($var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch || $var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch || $var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
            if ($var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
                $var = $var->class;
            } else {
                $var = $var->var;
            }
            $isSubNode = \true;
        }
        if (!$var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable || !\is_string($var->name)) {
            return [];
        }
        $certainty = $scope->hasVariableType($var->name);
        if ($certainty->no()) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s is never defined.', $var->name, $description))->build()];
        } elseif ($certainty->yes() && !$isSubNode) {
            $variableType = $scope->getVariableType($var->name);
            if ($variableType->isSuperTypeOf(new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType())->no()) {
                return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s always exists and is not nullable.', $var->name, $description))->build()];
            } elseif ((new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType())->isSuperTypeOf($variableType)->yes()) {
                return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s is always null.', $var->name, $description))->build()];
            }
        }
        return [];
    }
}
