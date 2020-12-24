<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Variables;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Isset_>
 */
class VariableCertaintyInIssetRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\Isset_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $messages = [];
        foreach ($node->vars as $var) {
            $isSubNode = \false;
            while ($var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch || $var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch || $var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch && $var->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
                if ($var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch) {
                    $var = $var->class;
                } else {
                    $var = $var->var;
                }
                $isSubNode = \true;
            }
            if (!$var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable || !\is_string($var->name) || $var->name === '_SESSION') {
                continue;
            }
            $certainty = $scope->hasVariableType($var->name);
            if ($certainty->no()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s in isset() is never defined.', $var->name))->build();
            } elseif ($certainty->yes() && !$isSubNode) {
                $variableType = $scope->getVariableType($var->name);
                if ($variableType->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\NullType())->no()) {
                    $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s in isset() always exists and is not nullable.', $var->name))->build();
                } elseif ((new \_PhpScopere8e811afab72\PHPStan\Type\NullType())->isSuperTypeOf($variableType)->yes()) {
                    $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Variable $%s in isset() is always null.', $var->name))->build();
                }
            }
        }
        return $messages;
    }
}
