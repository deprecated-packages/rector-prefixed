<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp80\Rector\NullsafeMethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafeMethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafePropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp80\Tests\Rector\NullsafeMethodCall\DowngradeNullsafeToTernaryOperatorRector\DowngradeNullsafeToTernaryOperatorRectorTest
 */
final class DowngradeNullsafeToTernaryOperatorRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change nullsafe operator to ternary operator rector', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$dateAsString = $booking->getStartDate()?->asDateTimeString();
$dateAsString = $booking->startDate?->dateTimeString;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$dateAsString = $booking->getStartDate() ? $booking->getStartDate()->asDateTimeString() : null;
$dateAsString = $booking->startDate ? $booking->startDate->dateTimeString : null;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafeMethodCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafePropertyFetch::class];
    }
    /**
     * @param NullsafeMethodCall|NullsafePropertyFetch $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $called = $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\NullsafeMethodCall ? new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($node->var, $node->name, $node->args) : new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch($node->var, $node->name);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary($node->var, $called, $this->createNull());
    }
}
