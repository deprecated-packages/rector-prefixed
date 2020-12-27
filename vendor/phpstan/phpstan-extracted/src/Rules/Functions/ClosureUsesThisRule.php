<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Rules\Functions;

use PhpParser\Node;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Rules\Rule;
use RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ThisType;
/**
 * @implements Rule<Node\Expr\Closure>
 */
class ClosureUsesThisRule implements \RectorPrefix20201227\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \PhpParser\Node\Expr\Closure::class;
    }
    public function processNode(\PhpParser\Node $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : array
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
            if (!$varType instanceof \PHPStan\Type\ThisType) {
                continue;
            }
            $messages[] = \RectorPrefix20201227\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Anonymous function uses $this assigned to variable $%s. Use $this directly in the function body.', $closureUse->var->name))->line($closureUse->getLine())->build();
        }
        return $messages;
    }
}
