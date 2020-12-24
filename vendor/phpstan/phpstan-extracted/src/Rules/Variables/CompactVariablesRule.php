<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Variables;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
final class CompactVariablesRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkMaybeUndefinedVariables;
    public function __construct(bool $checkMaybeUndefinedVariables)
    {
        $this->checkMaybeUndefinedVariables = $checkMaybeUndefinedVariables;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->name instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr) {
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
            if (!$argumentType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
                continue;
            }
            $variableName = $argumentType->getValue();
            $scopeHasVariable = $scope->hasVariableType($variableName);
            if ($scopeHasVariable->no()) {
                $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function compact() contains undefined variable $%s.', $variableName))->line($argument->getLine())->build();
            } elseif ($this->checkMaybeUndefinedVariables && $scopeHasVariable->maybe()) {
                $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function compact() contains possibly undefined variable $%s.', $variableName))->line($argument->getLine())->build();
            }
        }
        return $messages;
    }
}
