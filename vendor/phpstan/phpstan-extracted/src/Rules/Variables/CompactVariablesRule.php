<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Variables;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantStringType;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\FuncCall>
 */
final class CompactVariablesRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkMaybeUndefinedVariables;
    public function __construct(bool $checkMaybeUndefinedVariables)
    {
        $this->checkMaybeUndefinedVariables = $checkMaybeUndefinedVariables;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\FuncCall::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->name instanceof \PhpParser\Node\Expr) {
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
            if (!$argumentType instanceof \PHPStan\Type\Constant\ConstantStringType) {
                continue;
            }
            $variableName = $argumentType->getValue();
            $scopeHasVariable = $scope->hasVariableType($variableName);
            if ($scopeHasVariable->no()) {
                $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function compact() contains undefined variable $%s.', $variableName))->line($argument->getLine())->build();
            } elseif ($this->checkMaybeUndefinedVariables && $scopeHasVariable->maybe()) {
                $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Call to function compact() contains possibly undefined variable $%s.', $variableName))->line($argument->getLine())->build();
            }
        }
        return $messages;
    }
}
