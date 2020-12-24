<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Variables;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleError;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Unset_>
 */
class UnsetRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Unset_::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
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
    private function canBeUnset(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : ?\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleError
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable && \is_string($node->name)) {
            $hasVariable = $scope->hasVariableType($node->name);
            if ($hasVariable->no()) {
                return \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function unset() contains undefined variable $%s.', $node->name))->line($node->getLine())->build();
            }
        } elseif ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch && $node->dim !== null) {
            $type = $scope->getType($node->var);
            $dimType = $scope->getType($node->dim);
            if ($type->isOffsetAccessible()->no() || $type->hasOffsetValueType($dimType)->no()) {
                return \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot unset offset %s on %s.', $dimType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value()), $type->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())))->line($node->getLine())->build();
            }
            return $this->canBeUnset($node->var, $scope);
        }
        return null;
    }
}
