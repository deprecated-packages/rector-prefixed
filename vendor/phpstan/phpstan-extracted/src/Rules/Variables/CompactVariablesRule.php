<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Variables;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\Rule;
use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
final class CompactVariablesRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkMaybeUndefinedVariables;
    public function __construct(bool $checkMaybeUndefinedVariables)
    {
        $this->checkMaybeUndefinedVariables = $checkMaybeUndefinedVariables;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
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
            if (!$argumentType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType) {
                continue;
            }
            $variableName = $argumentType->getValue();
            $scopeHasVariable = $scope->hasVariableType($variableName);
            if ($scopeHasVariable->no()) {
                $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function compact() contains undefined variable $%s.', $variableName))->line($argument->getLine())->build();
            } elseif ($this->checkMaybeUndefinedVariables && $scopeHasVariable->maybe()) {
                $messages[] = \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function compact() contains possibly undefined variable $%s.', $variableName))->line($argument->getLine())->build();
            }
        }
        return $messages;
    }
}
