<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Comparison;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\VerbosityLevel;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\BinaryOp>
 */
class StrictComparisonOfDifferentTypesRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    /** @var bool */
    private $checkAlwaysTrueStrictComparison;
    public function __construct(bool $checkAlwaysTrueStrictComparison)
    {
        $this->checkAlwaysTrueStrictComparison = $checkAlwaysTrueStrictComparison;
    }
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\BinaryOp::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$node instanceof \PhpParser\Node\Expr\BinaryOp\Identical && !$node instanceof \PhpParser\Node\Expr\BinaryOp\NotIdentical) {
            return [];
        }
        $nodeType = $scope->getType($node);
        if (!$nodeType instanceof \PHPStan\Type\Constant\ConstantBooleanType) {
            return [];
        }
        $leftType = $scope->getType($node->left);
        $rightType = $scope->getType($node->right);
        if (!$nodeType->getValue()) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Strict comparison using %s between %s and %s will always evaluate to false.', $node instanceof \PhpParser\Node\Expr\BinaryOp\Identical ? '===' : '!==', $leftType->describe(\PHPStan\Type\VerbosityLevel::value()), $rightType->describe(\PHPStan\Type\VerbosityLevel::value())))->build()];
        } elseif ($this->checkAlwaysTrueStrictComparison) {
            return [\RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Strict comparison using %s between %s and %s will always evaluate to true.', $node instanceof \PhpParser\Node\Expr\BinaryOp\Identical ? '===' : '!==', $leftType->describe(\PHPStan\Type\VerbosityLevel::value()), $rightType->describe(\PHPStan\Type\VerbosityLevel::value())))->build()];
        }
        return [];
    }
}
