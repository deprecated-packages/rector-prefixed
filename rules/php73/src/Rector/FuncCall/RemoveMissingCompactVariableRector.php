<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Php73\Rector\FuncCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/bZ61T
 * @see \Rector\Php73\Tests\Rector\FuncCall\RemoveMissingCompactVariableRector\RemoveMissingCompactVariableRectorTest
 */
final class RemoveMissingCompactVariableRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove non-existing vars from compact()', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isName($node, 'compact')) {
            return null;
        }
        $scope = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope) {
            return null;
        }
        $this->unsetUnusedArrayElements($node, $scope);
        $this->unsetUnusedArguments($node, $scope);
        if ($node->args === []) {
            // Replaces the `compact()` call without any arguments with the empty array.
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_();
        }
        return $node;
    }
    private function unsetUnusedArrayElements(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : void
    {
        foreach ($funcCall->args as $positoin => $arg) {
            if (!$arg->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
                continue;
            }
            foreach ($arg->value->items as $arrayKey => $item) {
                if (!$item instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem) {
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
    private function unsetUnusedArguments(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $funcCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : void
    {
        foreach ($funcCall->args as $key => $arg) {
            if ($arg->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
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
