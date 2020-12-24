<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Rules\Functions;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Rules\Rule;
use _PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\ThisType;
/**
 * @implements Rule<Node\Expr\Closure>
 */
class ClosureUsesThisRule implements \_PhpScoper0a6b37af0871\PHPStan\Rules\Rule
{
    public function getNodeType() : string
    {
        return \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure::class;
    }
    public function processNode(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : array
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
            if (!$varType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ThisType) {
                continue;
            }
            $messages[] = \_PhpScoper0a6b37af0871\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Anonymous function uses $this assigned to variable $%s. Use $this directly in the function body.', $closureUse->var->name))->line($closureUse->getLine())->build();
        }
        return $messages;
    }
}
