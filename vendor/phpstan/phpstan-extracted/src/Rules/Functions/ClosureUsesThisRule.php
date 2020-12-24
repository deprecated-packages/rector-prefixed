<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Functions;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ThisType;
/**
 * @implements Rule<Node\Expr\Closure>
 */
class ClosureUsesThisRule implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure::class;
    }
    public function processNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : array
    {
        if ($node->static) {
            return [];
        }
        $messages = [];
        foreach ($node->uses as $closureUse) {
            $varType = $scope->getType($closureUse->var);
            if (!\is_string($closureUse->var->name)) {
                continue;
            }
            if (!$varType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ThisType) {
                continue;
            }
            $messages[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Anonymous function uses $this assigned to variable $%s. Use $this directly in the function body.', $closureUse->var->name))->line($closureUse->getLine())->build();
        }
        return $messages;
    }
}
