<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Operators;

use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\ErrorType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class InvalidIncDecOperationRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkThisOnly;
    public function __construct(bool $checkThisOnly)
    {
        $this->checkThisOnly = $checkThisOnly;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreInc && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostInc && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreDec && !$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostDec) {
            return [];
        }
        $operatorString = $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PreInc || $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PostInc ? '++' : '--';
        if (!$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable && !$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch && !$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch && !$node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot use %s on a non-variable.', $operatorString))->line($node->var->getLine())->build()];
        }
        if (!$this->checkThisOnly) {
            $varType = $scope->getType($node->var);
            if (!$varType->toString() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                return [];
            }
            if (!$varType->toNumber() instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ErrorType) {
                return [];
            }
            return [\_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Cannot use %s on %s.', $operatorString, $varType->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::value())))->line($node->var->getLine())->build()];
        }
        return [];
    }
}
