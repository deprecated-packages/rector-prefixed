<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Functions;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\UnusedFunctionParametersCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Closure>
 */
class UnusedClosureUsesRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\UnusedFunctionParametersCheck */
    private $check;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Rules\UnusedFunctionParametersCheck $check)
    {
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
    {
        if (\count($node->uses) === 0) {
            return [];
        }
        return $this->check->getUnusedParameters($scope, \array_map(static function (\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClosureUse $use) : string {
            if (!\is_string($use->var->name)) {
                throw new \_PhpScoper0a6b37af0871\PHPStan\ShouldNotHappenException();
            }
            return $use->var->name;
        }, $node->uses), $node->stmts, 'Anonymous function has an unused use $%s.', 'anonymousFunction.unusedUse', ['statementDepth' => $node->getAttribute('statementDepth'), 'statementOrder' => $node->getAttribute('statementOrder'), 'depth' => $node->getAttribute('expressionDepth'), 'order' => $node->getAttribute('expressionOrder')]);
    }
}
