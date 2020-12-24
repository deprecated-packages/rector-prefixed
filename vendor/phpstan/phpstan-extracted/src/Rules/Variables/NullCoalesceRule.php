<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Variables;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Rules\IssetCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class NullCoalesceRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var IssetCheck */
    private $issetCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\IssetCheck $issetCheck)
    {
        $this->issetCheck = $issetCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Coalesce) {
            $error = $this->issetCheck->check($node->left, $scope, 'on left side of ??');
        } elseif ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignOp\Coalesce) {
            $error = $this->issetCheck->check($node->var, $scope, 'on left side of ??=');
        } else {
            return [];
        }
        if ($error === null) {
            return [];
        }
        return [$error];
    }
}
