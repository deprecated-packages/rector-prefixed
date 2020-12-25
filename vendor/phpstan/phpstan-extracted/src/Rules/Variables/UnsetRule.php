<?php

declare (strict_types=1);
namespace PHPStan\Rules\Variables;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Unset_>
 */
class UnsetRule implements \PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Stmt\Unset_::class;
    }
    public function processNode(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : array
    {
        $functionArguments = $node->vars;
        $errors = [];
        foreach ($functionArguments as $argument) {
            $error = $this->canBeUnset($argument, $scope);
            if ($error === null) {
                continue;
            }
            $errors[] = $error;
        }
        return $errors;
    }
    private function canBeUnset(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : ?\PHPStan\Rules\RuleError
    {
        if ($node instanceof \PhpParser\Node\Expr\Variable && \is_string($node->name)) {
            $hasVariable = $scope->hasVariableType($node->name);
            if ($hasVariable->no()) {
                return \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function unset() contains undefined variable $%s.', $node->name))->line($node->getLine())->build();
            }
        } elseif ($node instanceof \PhpParser\Node\Expr\ArrayDimFetch && $node->dim !== null) {
            $type = $scope->getType($node->var);
            $dimType = $scope->getType($node->dim);
            if ($type->isOffsetAccessible()->no() || $type->hasOffsetValueType($dimType)->no()) {
                return \PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot unset offset %s on %s.', $dimType->describe(\PHPStan\Type\VerbosityLevel::value()), $type->describe(\PHPStan\Type\VerbosityLevel::value())))->line($node->getLine())->build();
            }
            return $this->canBeUnset($node->var, $scope);
        }
        return null;
    }
}
