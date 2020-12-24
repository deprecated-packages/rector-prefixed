<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Functions;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\UnusedFunctionParametersCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Expr\Closure>
 */
class UnusedClosureUsesRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\UnusedFunctionParametersCheck */
    private $check;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Rules\UnusedFunctionParametersCheck $check)
    {
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
    {
        if (\count($node->uses) === 0) {
            return [];
        }
        return $this->check->getUnusedParameters($scope, \array_map(static function (\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ClosureUse $use) : string {
            if (!\is_string($use->var->name)) {
                throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
            }
            return $use->var->name;
        }, $node->uses), $node->stmts, 'Anonymous function has an unused use $%s.', 'anonymousFunction.unusedUse', ['statementDepth' => $node->getAttribute('statementDepth'), 'statementOrder' => $node->getAttribute('statementOrder'), 'depth' => $node->getAttribute('expressionDepth'), 'order' => $node->getAttribute('expressionOrder')]);
    }
}
