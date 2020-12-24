<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\DeadCode;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Expression>
 */
class NoopRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var Standard */
    private $printer;
    public function __construct(\_PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard $printer)
    {
        $this->printer = $printer;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $originalExpr = $node->expr;
        $expr = $originalExpr;
        if ($expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryMinus || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\UnaryPlus || $expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ErrorSuppress) {
            $expr = $expr->expr;
        }
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticPropertyFetch && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafePropertyFetch && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Isset_ && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Empty_ && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch && !$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch) {
            return [];
        }
        return [\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Expression "%s" on a separate line does not do anything.', $this->printer->prettyPrintExpr($originalExpr)))->line($expr->getLine())->identifier('deadCode.noopExpression')->metadata(['depth' => $node->getAttribute('statementDepth'), 'order' => $node->getAttribute('statementOrder')])->build()];
    }
}
