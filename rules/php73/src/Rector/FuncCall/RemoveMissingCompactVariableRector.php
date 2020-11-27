<?php

declare (strict_types=1);
namespace Rector\Php73\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/bZ61T
 * @see \Rector\Php73\Tests\Rector\FuncCall\RemoveMissingCompactVariableRector\RemoveMissingCompactVariableRectorTest
 */
final class RemoveMissingCompactVariableRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove non-existing vars from compact()', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isName($node, 'compact')) {
            return null;
        }
        $scope = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if (!$scope instanceof \PHPStan\Analyser\Scope) {
            return null;
        }
        $this->unsetUnusedArrayElements($node, $scope);
        $this->unsetUnusedArguments($node, $scope);
        if ($node->args === []) {
            // Replaces the `compact()` call without any arguments with the empty array.
            return new \PhpParser\Node\Expr\Array_();
        }
        return $node;
    }
    private function unsetUnusedArrayElements(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : void
    {
        foreach ($node->args as $key => $arg) {
            if (!$arg->value instanceof \PhpParser\Node\Expr\Array_) {
                continue;
            }
            foreach ($arg->value->items as $arrayKey => $item) {
                $value = $this->getValue($item->value);
                if ($scope->hasVariableType($value)->yes()) {
                    continue;
                }
                unset($arg->value->items[$arrayKey]);
            }
            if ($arg->value->items === []) {
                // Drops empty array from `compact()` arguments.
                unset($node->args[$key]);
            }
        }
    }
    private function unsetUnusedArguments(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : void
    {
        foreach ($node->args as $key => $arg) {
            if ($arg->value instanceof \PhpParser\Node\Expr\Array_) {
                continue;
            }
            $argValue = $this->getValue($arg->value);
            if (!$scope->hasVariableType($argValue)->no()) {
                continue;
            }
            unset($node->args[$key]);
        }
    }
}
