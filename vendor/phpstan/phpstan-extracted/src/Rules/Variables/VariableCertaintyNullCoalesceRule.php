<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Variables;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
/**
 * @implements \PHPStan\Rules\Rule<Node\Expr>
 */
class VariableCertaintyNullCoalesceRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp\Coalesce) {
            $var = $node->var;
            $description = '??=';
        } elseif ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Coalesce) {
            $var = $node->left;
            $description = '??';
        } else {
            return [];
        }
        $isSubNode = \false;
        while ($var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch || $var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch || $var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
            if ($var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch) {
                $var = $var->class;
            } else {
                $var = $var->var;
            }
            $isSubNode = \true;
        }
        if (!$var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable || !\is_string($var->name)) {
            return [];
        }
        $certainty = $scope->hasVariableType($var->name);
        if ($certainty->no()) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s is never defined.', $var->name, $description))->build()];
        } elseif ($certainty->yes() && !$isSubNode) {
            $variableType = $scope->getVariableType($var->name);
            if ($variableType->isSuperTypeOf(new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType())->no()) {
                return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s always exists and is not nullable.', $var->name, $description))->build()];
            } elseif ((new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType())->isSuperTypeOf($variableType)->yes()) {
                return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s on left side of %s is always null.', $var->name, $description))->build()];
            }
        }
        return [];
    }
}
