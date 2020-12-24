<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Php56\Rector\FunctionLike;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignRef;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Unset_ as UnsetCast;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\List_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Global_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Static_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\StaticVar;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Unset_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/vimeo/psalm/blob/29b70442b11e3e66113935a2ee22e165a70c74a4/docs/fixing_code.md#possiblyundefinedvariable
 * @see https://3v4l.org/MZFel
 *
 * @see \Rector\Php56\Tests\Rector\FunctionLike\AddDefaultValueForUndefinedVariableRector\AddDefaultValueForUndefinedVariableRectorTest
 */
final class AddDefaultValueForUndefinedVariableRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private $definedVariables = [];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds default value for undefined variable', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
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
            $variablesInitiation[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable($undefinedVariable), $this->createNull()));
        }
        $node->stmts = \array_merge($variablesInitiation, (array) $node->stmts);
        return $node;
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     * @return string[]
     */
    private function collectUndefinedVariableScope(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : array
    {
        $undefinedVariables = [];
        $this->traverseNodesWithCallable((array) $node->stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) use(&$undefinedVariables) : ?int {
            // entering new scope - break!
            if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike && !$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrowFunction) {
                return \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser::STOP_TRAVERSAL;
            }
            if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_) {
                // handled above
                $this->collectDefinedVariablesFromForeach($node);
                return \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if (!$node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if ($this->shouldSkipVariable($node)) {
                return null;
            }
            /** @var string $variableName */
            $variableName = $this->getName($node);
            // defined 100 %
            /** @var Scope $nodeScope */
            $nodeScope = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            if ($nodeScope->hasVariableType($variableName)->yes()) {
                return null;
            }
            $undefinedVariables[] = $variableName;
            return null;
        });
        return \array_unique($undefinedVariables);
    }
    private function collectDefinedVariablesFromForeach(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_ $foreach) : void
    {
        $this->traverseNodesWithCallable((array) $foreach->stmts, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void {
            if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign || $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignRef) {
                if (!$node->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
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
    private function shouldSkipVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $parentNode = $variable->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Global_) {
            return \true;
        }
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node && ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign || $parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\AssignRef || $this->isStaticVariable($parentNode))) {
            return \true;
        }
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Unset_) {
            return \true;
        }
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Unset_) {
            return \true;
        }
        // list() = | [$values] = defines variables as null
        if ($this->isListAssign($parentNode)) {
            return \true;
        }
        /** @var Scope|null $nodeScope */
        $nodeScope = $variable->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
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
    private function isStaticVariable(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $parentNode) : bool
    {
        // definition of static variable
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\StaticVar) {
            $parentParentNode = $parentNode->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Static_) {
                return \true;
            }
        }
        return \false;
    }
    private function isListAssign(?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $parentNode) : bool
    {
        if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node) {
            $parentParentNode = $parentNode->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\List_) {
                return \true;
            }
            if ($parentParentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_) {
                return \true;
            }
        }
        return \false;
    }
}
