<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Variables;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
final class CompactVariablesRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkMaybeUndefinedVariables;
    public function __construct(bool $checkMaybeUndefinedVariables)
    {
        $this->checkMaybeUndefinedVariables = $checkMaybeUndefinedVariables;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->name instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr) {
            return [];
        }
        $functionName = \strtolower($node->name->toString());
        if ($functionName !== 'compact') {
            return [];
        }
        $functionArguments = $node->args;
        $messages = [];
        foreach ($functionArguments as $argument) {
            $argumentType = $scope->getType($argument->value);
            if (!$argumentType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
                continue;
            }
            $variableName = $argumentType->getValue();
            $scopeHasVariable = $scope->hasVariableType($variableName);
            if ($scopeHasVariable->no()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function compact() contains undefined variable $%s.', $variableName))->line($argument->getLine())->build();
            } elseif ($this->checkMaybeUndefinedVariables && $scopeHasVariable->maybe()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function compact() contains possibly undefined variable $%s.', $variableName))->line($argument->getLine())->build();
            }
        }
        return $messages;
    }
}
