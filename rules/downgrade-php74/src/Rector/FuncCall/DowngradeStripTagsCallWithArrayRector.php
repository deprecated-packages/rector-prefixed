<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\DowngradePhp74\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp74\Tests\Rector\FuncCall\DowngradeStripTagsCallWithArrayRector\DowngradeStripTagsCallWithArrayRectorTest
 */
final class DowngradeStripTagsCallWithArrayRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->variableNaming = $variableNaming;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Convert 2nd param to `strip_tags` from array to string', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($string)
    {
        // Arrays: change to string
        strip_tags($string, ['a', 'p']);

        // Variables/consts/properties: if array, change to string
        $tags = ['a', 'p'];
        strip_tags($string, $tags);

        // Default case (eg: function call): externalize to var, then if array, change to string
        strip_tags($string, getTags());
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($string)
    {
        // Arrays: change to string
        strip_tags($string, '<' . implode('><', ['a', 'p']) . '>');

        // Variables/consts/properties: if array, change to string
        $tags = ['a', 'p'];
        strip_tags($string, $tags !== null && is_array($tags) ? '<' . implode('><', $tags) . '>' : $tags);

        // Default case (eg: function call): externalize to var, then if array, change to string
        $expr = getTags();
        strip_tags($string, is_array($expr) ? '<' . implode('><', $expr) . '>' : $expr);
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->shouldRefactor($node)) {
            return null;
        }
        $allowableTagsParam = $node->args[1]->value;
        if ($allowableTagsParam instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
            // If it is an array, convert it to string
            $newExpr = $this->createArrayFromString($allowableTagsParam);
        } elseif ($allowableTagsParam instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable || $allowableTagsParam instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch || $allowableTagsParam instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch || $allowableTagsParam instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch) {
            // If it is a variable or a const (other than null), add logic to maybe convert to string
            $newExpr = $this->createIsArrayTernaryFromExpression($allowableTagsParam);
        } else {
            // It is a function or method call, ternary or coalesce, or any other:
            // Assign the value to a variable
            // First obtain a variable name that does not exist in the node (to not override its value)
            $variableName = $this->variableNaming->resolveFromFuncCallFirstArgumentWithSuffix($node, 'AllowableTags', 'allowableTags', $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE));
            // Assign the value to the variable
            $newVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableName);
            $this->addNodeBeforeNode(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($newVariable, $allowableTagsParam), $node);
            // Apply refactor on the variable
            $newExpr = $this->createIsArrayTernaryFromExpression($newVariable);
        }
        // Replace the arg with a new one
        \array_splice($node->args, 1, 1, [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($newExpr)]);
        return $node;
    }
    private function shouldRefactor(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        if (!$this->isName($funcCall, 'strip_tags')) {
            return \false;
        }
        // If param not provided, do nothing
        if (\count((array) $funcCall->args) < 2) {
            return \false;
        }
        // Process anything other than String and null (eg: variables, function calls)
        $allowableTagsParam = $funcCall->args[1]->value;
        // Skip for string
        if ($allowableTagsParam instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return \false;
        }
        // Skip for null
        // Allow for everything else (Array_, Variable, PropertyFetch, ConstFetch, ClassConstFetch, FuncCall, MethodCall, Coalesce, Ternary, others?)
        return !$this->isNull($allowableTagsParam);
    }
    /**
     * @param Array_|Variable|PropertyFetch|ConstFetch|ClassConstFetch $expr
     */
    private function createArrayFromString(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat
    {
        $args = [new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_('><')), new \_PhpScopere8e811afab72\PhpParser\Node\Arg($expr)];
        $implodeFuncCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name('implode'), $args);
        $concat = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat(new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_('<'), $implodeFuncCall);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Concat($concat, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_('>'));
    }
    /**
     * @param Variable|PropertyFetch|ConstFetch|ClassConstFetch $expr
     */
    private function createIsArrayTernaryFromExpression(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary
    {
        $isArrayFuncCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name('is_array'), [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($expr)]);
        $nullNotIdentical = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical($expr, $this->createNull());
        $booleanAnd = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd($nullNotIdentical, $isArrayFuncCall);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Ternary($booleanAnd, $this->createArrayFromString($expr), $expr);
    }
}
