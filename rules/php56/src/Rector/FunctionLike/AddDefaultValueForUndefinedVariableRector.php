<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Php56\Rector\FunctionLike;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrowFunction;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Unset_ as UnsetCast;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\List_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Global_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Static_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\StaticVar;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Unset_;
use _PhpScoper0a6b37af0871\PhpParser\NodeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/vimeo/psalm/blob/29b70442b11e3e66113935a2ee22e165a70c74a4/docs/fixing_code.md#possiblyundefinedvariable
 * @see https://3v4l.org/MZFel
 *
 * @see \Rector\Php56\Tests\Rector\FunctionLike\AddDefaultValueForUndefinedVariableRector\AddDefaultValueForUndefinedVariableRectorTest
 */
final class AddDefaultValueForUndefinedVariableRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private $definedVariables = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds default value for undefined variable', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Closure::class];
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
            $variablesInitiation[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($undefinedVariable), $this->createNull()));
        }
        $node->stmts = \array_merge($variablesInitiation, (array) $node->stmts);
        return $node;
    }
    /**
     * @param ClassMethod|Function_|Closure $node
     * @return string[]
     */
    private function collectUndefinedVariableScope(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : array
    {
        $undefinedVariables = [];
        $this->traverseNodesWithCallable((array) $node->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use(&$undefinedVariables) : ?int {
            // entering new scope - break!
            if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\FunctionLike && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrowFunction) {
                return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::STOP_TRAVERSAL;
            }
            if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_) {
                // handled above
                $this->collectDefinedVariablesFromForeach($node);
                return \_PhpScoper0a6b37af0871\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
            }
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
                return null;
            }
            if ($this->shouldSkipVariable($node)) {
                return null;
            }
            /** @var string $variableName */
            $variableName = $this->getName($node);
            // defined 100 %
            /** @var Scope $nodeScope */
            $nodeScope = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
            if ($nodeScope->hasVariableType($variableName)->yes()) {
                return null;
            }
            $undefinedVariables[] = $variableName;
            return null;
        });
        return \array_unique($undefinedVariables);
    }
    private function collectDefinedVariablesFromForeach(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Foreach_ $foreach) : void
    {
        $this->traverseNodesWithCallable((array) $foreach->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : void {
            if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign || $node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef) {
                if (!$node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable) {
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
    private function shouldSkipVariable(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $parentNode = $variable->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Global_) {
            return \true;
        }
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node && ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign || $parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\AssignRef || $this->isStaticVariable($parentNode))) {
            return \true;
        }
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Unset_ || $parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Cast\Unset_) {
            return \true;
        }
        // list() = | [$values] = defines variables as null
        if ($this->isListAssign($parentNode)) {
            return \true;
        }
        /** @var Scope|null $nodeScope */
        $nodeScope = $variable->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::SCOPE);
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
    private function isStaticVariable(\_PhpScoper0a6b37af0871\PhpParser\Node $parentNode) : bool
    {
        // definition of static variable
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\StaticVar) {
            $parentParentNode = $parentNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Static_) {
                return \true;
            }
        }
        return \false;
    }
    private function isListAssign(?\_PhpScoper0a6b37af0871\PhpParser\Node $parentNode) : bool
    {
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node) {
            $parentParentNode = $parentNode->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentParentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\List_ || $parentParentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
                return \true;
            }
        }
        return \false;
    }
}
