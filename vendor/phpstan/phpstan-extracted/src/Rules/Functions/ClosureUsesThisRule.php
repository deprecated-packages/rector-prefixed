<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Rules\Functions;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Rule;
use _PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\ThisType;
/**
 * @implements Rule<Node\Expr\Closure>
 */
class ClosureUsesThisRule implements \_PhpScoperb75b35f52b74\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Closure::class;
    }
    public function processNode(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : array
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
            if (!$varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ThisType) {
                continue;
            }
            $messages[] = \_PhpScoperb75b35f52b74\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Anonymous function uses $this assigned to variable $%s. Use $this directly in the function body.', $closureUse->var->name))->line($closureUse->getLine())->build();
        }
        return $messages;
    }
}
