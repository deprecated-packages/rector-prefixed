<?php

declare (strict_types=1);
namespace Rector\Core\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp;
use PhpParser\Node\Expr\BooleanNot;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\NullsafeMethodCall;
use PhpParser\Node\Expr\StaticCall;
final class CallAnalyzer
{
    /**
     * @var array<class-string<Expr>>
     */
    private const OBJECT_CALLS = [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\NullsafeMethodCall::class, \PhpParser\Node\Expr\StaticCall::class];
    public function isObjectCall(\PhpParser\Node $node) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\BooleanNot) {
            $node = $node->expr;
        }
        if ($node instanceof \PhpParser\Node\Expr\BinaryOp) {
            $isObjectCallLeft = $this->isObjectCall($node->left);
            $isObjectCallRight = $this->isObjectCall($node->right);
            return $isObjectCallLeft || $isObjectCallRight;
        }
        foreach (self::OBJECT_CALLS as $objectCall) {
            if (\is_a($node, $objectCall, \true)) {
                return \true;
            }
        }
        return \false;
    }
}
