<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules\Operators;

use _PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidIncDecOperationRule implements \_PhpScoper0a2ac50786fa\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkThisOnly;
    public function __construct(bool $checkThisOnly)
    {
        $this->checkThisOnly = $checkThisOnly;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreInc && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostInc && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreDec && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostDec) {
            return [];
        }
        $operatorString = $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PreInc || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PostInc ? '++' : '--';
        if (!$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable && !$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch && !$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch && !$node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot use %s on a non-variable.', $operatorString))->line($node->var->getLine())->build()];
        }
        if (!$this->checkThisOnly) {
            $varType = $scope->getType($node->var);
            if (!$varType->toString() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
                return [];
            }
            if (!$varType->toNumber() instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ErrorType) {
                return [];
            }
            return [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot use %s on %s.', $operatorString, $varType->describe(\_PhpScoper0a2ac50786fa\PHPStan\Type\VerbosityLevel::value())))->line($node->var->getLine())->build()];
        }
        return [];
    }
}
