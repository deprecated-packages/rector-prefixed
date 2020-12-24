<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Variables;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\IssetCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr>
 */
class NullCoalesceRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var IssetCheck */
    private $issetCheck;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\IssetCheck $issetCheck)
    {
        $this->issetCheck = $issetCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Coalesce) {
            $error = $this->issetCheck->check($node->left, $scope, 'on left side of ??');
        } elseif ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignOp\Coalesce) {
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
