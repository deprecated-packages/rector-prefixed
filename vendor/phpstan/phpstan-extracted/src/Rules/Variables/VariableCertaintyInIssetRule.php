<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Variables;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Isset_>
 */
class VariableCertaintyInIssetRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Isset_::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->vars as $var) {
            $isSubNode = \false;
            while ($var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch || $var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch || $var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr) {
                if ($var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticPropertyFetch) {
                    $var = $var->class;
                } else {
                    $var = $var->var;
                }
                $isSubNode = \true;
            }
            if (!$var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable || !\is_string($var->name) || $var->name === '_SESSION') {
                continue;
            }
            $certainty = $scope->hasVariableType($var->name);
            if ($certainty->no()) {
                $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s in isset() is never defined.', $var->name))->build();
            } elseif ($certainty->yes() && !$isSubNode) {
                $variableType = $scope->getVariableType($var->name);
                if ($variableType->isSuperTypeOf(new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType())->no()) {
                    $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s in isset() always exists and is not nullable.', $var->name))->build();
                } elseif ((new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType())->isSuperTypeOf($variableType)->yes()) {
                    $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s in isset() is always null.', $var->name))->build();
                }
            }
        }
        return $messages;
    }
}
