<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\DowngradePhp80\Rector\NullsafeMethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafeMethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafePropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp80\Tests\Rector\NullsafeMethodCall\DowngradeNullsafeToTernaryOperatorRector\DowngradeNullsafeToTernaryOperatorRectorTest
 */
final class DowngradeNullsafeToTernaryOperatorRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change nullsafe operator to ternary operator rector', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafeMethodCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafePropertyFetch::class];
    }
    /**
     * @param NullsafeMethodCall|NullsafePropertyFetch $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $called = $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\NullsafeMethodCall ? new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($node->var, $node->name, $node->args) : new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch($node->var, $node->name);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary($node->var, $called, $this->createNull());
    }
}
