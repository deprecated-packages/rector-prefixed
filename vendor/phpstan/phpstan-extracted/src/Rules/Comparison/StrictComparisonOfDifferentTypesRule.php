<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Comparison;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp>
 */
class StrictComparisonOfDifferentTypesRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkAlwaysTrueStrictComparison;
    public function __construct(bool $checkAlwaysTrueStrictComparison)
    {
        $this->checkAlwaysTrueStrictComparison = $checkAlwaysTrueStrictComparison;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return [];
        }
        $nodeType = $scope->getType($node);
        if (!$nodeType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType) {
            return [];
        }
        $leftType = $scope->getType($node->left);
        $rightType = $scope->getType($node->right);
        if (!$nodeType->getValue()) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Strict comparison using %s between %s and %s will always evaluate to false.', $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical ? '===' : '!==', $leftType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value()), $rightType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())))->build()];
        } elseif ($this->checkAlwaysTrueStrictComparison) {
            return [\_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Strict comparison using %s between %s and %s will always evaluate to true.', $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical ? '===' : '!==', $leftType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value()), $rightType->describe(\_PhpScoper0a6b37af0871\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        return [];
    }
}
