<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\DowngradePhp74\Rector\Array_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IterableType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Traversable;
/**
 * @see \Rector\DowngradePhp74\Tests\Rector\Array_\DowngradeArraySpreadRector\DowngradeArraySpreadRectorTest
 */
final class DowngradeArraySpreadRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replace array spread with array_merge function', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $parts = ['apple', 'pear'];
        $fruits = ['banana', 'orange', ...$parts, 'watermelon'];
    }

    public function runWithIterable()
    {
        $fruits = ['banana', 'orange', ...new ArrayIterator(['durian', 'kiwi']), 'watermelon'];
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $parts = ['apple', 'pear'];
        $fruits = array_merge(['banana', 'orange'], $parts, ['watermelon']);
    }

    public function runWithIterable()
    {
        $item0Unpacked = new ArrayIterator(['durian', 'kiwi']);
        $fruits = array_merge(['banana', 'orange'], is_array($item0Unpacked) ? $item0Unpacked : iterator_to_array($item0Unpacked), ['watermelon']);
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_::class];
    }
    /**
     * @param Array_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->shouldRefactor($node)) {
            return null;
        }
        return $this->refactorNode($node);
    }
    private function shouldRefactor(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array) : bool
    {
        // Check that any item in the array is the spread
        return \array_filter($array->items, function (?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem $item) : bool {
            if ($item === null) {
                return \false;
            }
            return $item->unpack;
        }) !== [];
    }
    private function refactorNode(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $newItems = $this->createArrayItems($array);
        // Replace this array node with an `array_merge`
        return $this->createArrayMerge($array, $newItems);
    }
    /**
     * Iterate all array items:
     * 1. If they use the spread, remove it
     * 2. If not, make the item part of an accumulating array,
     *    to be added once the next spread is found, or at the end
     * @return ArrayItem[]
     */
    private function createArrayItems(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array) : array
    {
        $newItems = [];
        $accumulatedItems = [];
        /** @var Scope */
        $nodeScope = $array->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        foreach ($array->items as $position => $item) {
            if ($item !== null && $item->unpack) {
                // Spread operator found
                if (!$item->value instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
                    // If it is a not variable, transform it to a variable
                    // Keep the original type, will be needed later
                    $item->setAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_TYPE, $nodeScope->getType($item->value));
                    $item->value = $this->createVariableFromNonVariable($array, $item, $position);
                }
                if ($accumulatedItems !== []) {
                    // If previous items were in the new array, add them first
                    $newItems[] = $this->createArrayItem($accumulatedItems);
                    // Reset the accumulated items
                    $accumulatedItems = [];
                }
                // Add the current item, still with "unpack = true" (it will be removed later on)
                $newItems[] = $item;
                continue;
            }
            // Normal item, it goes into the accumulated array
            $accumulatedItems[] = $item;
        }
        // Add the remaining accumulated items
        if ($accumulatedItems !== []) {
            $newItems[] = $this->createArrayItem($accumulatedItems);
        }
        return $newItems;
    }
    /**
     * @see https://wiki.php.net/rfc/spread_operator_for_array
     * @param (ArrayItem|null)[] $items
     */
    private function createArrayMerge(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array, array $items) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall
    {
        /** @var Scope */
        $nodeScope = $array->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('array_merge'), \array_map(function (\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem $item) use($nodeScope) : Arg {
            if ($item !== null && $item->unpack) {
                // Do not unpack anymore
                $item->unpack = \false;
                return $this->createArgFromSpreadArrayItem($nodeScope, $item);
            }
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($item);
        }, $items));
    }
    /**
     * If it is a variable, we add it directly
     * Otherwise it could be a function, method, ternary, traversable, etc
     * We must then first extract it into a variable,
     * as to invoke it only once and avoid potential bugs,
     * such as a method executing some side-effect
     * @param int|string $position
     */
    private function createVariableFromNonVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem $arrayItem, $position) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable
    {
        /** @var Scope */
        $nodeScope = $array->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        // The variable name will be item0Unpacked, item1Unpacked, etc,
        // depending on their position.
        // The number can't be at the end of the var name, or it would
        // conflict with the counter (for if that name is already taken)
        $variableName = $this->variableNaming->resolveFromNodeWithScopeCountAndFallbackName($array, $nodeScope, 'item' . $position . 'Unpacked');
        // Assign the value to the variable, and replace the element with the variable
        $newVariable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($variableName);
        $this->addNodeBeforeNode(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($newVariable, $arrayItem->value), $array);
        return $newVariable;
    }
    /**
     * @param (ArrayItem|null)[] $items
     */
    private function createArrayItem(array $items) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem
    {
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_($items));
    }
    private function createArgFromSpreadArrayItem(\_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $nodeScope, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem $arrayItem) : \_PhpScoper0a6b37af0871\PhpParser\Node\Arg
    {
        // By now every item is a variable
        /** @var Variable */
        $variable = $arrayItem->value;
        $variableName = $this->getName($variable) ?? '';
        // If the variable is not in scope, it's one we just added.
        // Then get the type from the attribute
        $type = $nodeScope->hasVariableType($variableName)->yes() ? $nodeScope->getVariableType($variableName) : $arrayItem->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_TYPE);
        $iteratorToArrayFuncCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('iterator_to_array'), [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($arrayItem)]);
        if ($type !== null) {
            // If we know it is an array, then print it directly
            // Otherwise PHPStan throws an error:
            // "Else branch is unreachable because ternary operator condition is always true."
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType) {
                return new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($arrayItem);
            }
            // If it is iterable, then directly return `iterator_to_array`
            if ($this->isIterableType($type)) {
                return new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($iteratorToArrayFuncCall);
            }
        }
        // Print a ternary, handling either an array or an iterator
        $inArrayFuncCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('is_array'), [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($arrayItem)]);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Ternary($inArrayFuncCall, $arrayItem, $iteratorToArrayFuncCall));
    }
    /**
     * Iterables: either objects declaring the interface Traversable,
     * or the pseudo-type iterable
     */
    private function isIterableType(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IterableType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType && \is_a($type->getClassName(), \Traversable::class, \true);
    }
}
