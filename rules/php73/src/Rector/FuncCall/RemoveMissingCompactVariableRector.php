<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php73\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/bZ61T
 * @see \Rector\Php73\Tests\Rector\FuncCall\RemoveMissingCompactVariableRector\RemoveMissingCompactVariableRectorTest
 */
final class RemoveMissingCompactVariableRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove non-existing vars from compact()', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = 'yes';

        compact('value', 'non_existing');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $value = 'yes';

        compact('value');
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isName($node, 'compact')) {
            return null;
        }
        $scope = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope) {
            return null;
        }
        $this->unsetUnusedArrayElements($node, $scope);
        $this->unsetUnusedArguments($node, $scope);
        if ($node->args === []) {
            // Replaces the `compact()` call without any arguments with the empty array.
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_();
        }
        return $node;
    }
    private function unsetUnusedArrayElements(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : void
    {
        foreach ($funcCall->args as $positoin => $arg) {
            if (!$arg->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
                continue;
            }
            foreach ($arg->value->items as $arrayKey => $item) {
                if (!$item instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem) {
                    continue;
                }
                $value = $this->getValue($item->value);
                if ($scope->hasVariableType($value)->yes()) {
                    continue;
                }
                unset($arg->value->items[$arrayKey]);
            }
            if ($arg->value->items === []) {
                // Drops empty array from `compact()` arguments.
                unset($funcCall->args[$positoin]);
            }
        }
    }
    private function unsetUnusedArguments(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : void
    {
        foreach ($funcCall->args as $key => $arg) {
            if ($arg->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
                continue;
            }
            $argValue = $this->getValue($arg->value);
            if (!$scope->hasVariableType($argValue)->no()) {
                continue;
            }
            unset($funcCall->args[$key]);
        }
    }
}
