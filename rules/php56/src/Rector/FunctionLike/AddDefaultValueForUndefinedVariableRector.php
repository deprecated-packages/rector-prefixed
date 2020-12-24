<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php56\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Unset_ as UnsetCast;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\List_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Global_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Static_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\StaticVar;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Unset_;
use _PhpScopere8e811afab72\PhpParser\NodeTraverser;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/vimeo/psalm/blob/29b70442b11e3e66113935a2ee22e165a70c74a4/docs/fixing_code.md#possiblyundefinedvariable
 * @see https://3v4l.org/MZFel
 *
 * @see \Rector\Php56\Tests\Rector\FunctionLike\AddDefaultValueForUndefinedVariableRector\AddDefaultValueForUndefinedVariableRectorTest
 */
final class AddDefaultValueForUndefinedVariableRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private $definedVariables = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds default value for undefined variable', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        if (rand(0, 1)) {
            $a = 5;
        }
        echo $a;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $a = null;
        if (rand(0, 1)) {
            $a = 5;
        }
        echo $a;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $this->definedVariables = [];
        $undefinedVariables = $this->collectUndefinedVariableScope($node);
        if ($undefinedVariables === []) {
            return null;
        }
        $variablesInitiation = [];
        foreach ($undefinedVariables as $undefinedVariable) {
            if (\in_array($undefinedVariable, $this->definedVariables, \true)) {
                continue;
            }
            $variablesInitiation[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($undefinedVariable), $this->createNull()));
        }
        $node->stmts = \array_merge($variablesInitiation, (array) $node->stmts);
        return $node;
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     * @return string[]
     */
    private function collectUndefinedVariableScope(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        $undefinedVariables = [];
        $this->traverseNodesWithCallable((array) $node->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) use(&$undefinedVariables) : ?int {
            // entering new scope - break!
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\FunctionLike && !$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction) {
                return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::STOP_TRAVERSAL;
            }
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_) {
                // handled above
                $this->collectDefinedVariablesFromForeach($node);
                return \_PhpScopere8e811afab72\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if ($this->shouldSkipVariable($node)) {
                return null;
            }
            /** @var string $variableName */
            $variableName = $this->getName($node);
            // defined 100 %
            /** @var Scope $nodeScope */
            $nodeScope = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            if ($nodeScope->hasVariableType($variableName)->yes()) {
                return null;
            }
            $undefinedVariables[] = $variableName;
            return null;
        });
        return \array_unique($undefinedVariables);
    }
    private function collectDefinedVariablesFromForeach(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Foreach_ $foreach) : void
    {
        $this->traverseNodesWithCallable((array) $foreach->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : void {
            if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef) {
                if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
                    return;
                }
                $variableName = $this->getName($node->var);
                if ($variableName === null) {
                    return;
                }
                $this->definedVariables[] = $variableName;
            }
        });
    }
    private function shouldSkipVariable(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $parentNode = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Global_) {
            return \true;
        }
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node && ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign || $parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\AssignRef || $this->isStaticVariable($parentNode))) {
            return \true;
        }
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Unset_ || $parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Unset_) {
            return \true;
        }
        // list() = | [$values] = defines variables as null
        if ($this->isListAssign($parentNode)) {
            return \true;
        }
        /** @var Scope|null $nodeScope */
        $nodeScope = $variable->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
        if ($nodeScope === null) {
            return \true;
        }
        $variableName = $this->getName($variable);
        // skip $this, as probably in outer scope
        if ($variableName === 'this') {
            return \true;
        }
        return $variableName === null;
    }
    private function isStaticVariable(\_PhpScopere8e811afab72\PhpParser\Node $parentNode) : bool
    {
        // definition of static variable
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\StaticVar) {
            $parentParentNode = $parentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Static_) {
                return \true;
            }
        }
        return \false;
    }
    private function isListAssign(?\_PhpScopere8e811afab72\PhpParser\Node $parentNode) : bool
    {
        if ($parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node) {
            $parentParentNode = $parentNode->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\List_ || $parentParentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
                return \true;
            }
        }
        return \false;
    }
}
